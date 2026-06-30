<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->start_date ?: now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?: now()->endOfMonth()->toDateString();

        // Calculate Metrics
        $grossRevenue = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->sum('grand_total');
        $totalPesanan = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->count();

        $pengembalianStats = DB::table('pengembalians')
            ->join('produks', 'pengembalians.produk_id', '=', 'produks.id')
            ->whereBetween('pengembalians.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(pengembalians.quantity * produks.price_sell) as total_pengembalian_revenue, SUM(pengembalians.quantity * produks.cogs) as total_pengembalian_cogs, SUM(pengembalians.quantity) as total_pengembalian_quantity')
            ->first();

        $totalPengembalianRevenue = $pengembalianStats->total_pengembalian_revenue ?? 0;
        $totalPengembalianCogs = $pengembalianStats->total_pengembalian_cogs ?? 0;
        $totalPengembalianQuantity = $pengembalianStats->total_pengembalian_quantity ?? 0;

        $grossRevenue -= $totalPengembalianRevenue;

        $notaStats = DB::table('notas')
            ->join('penjualans', 'notas.no_nota', '=', 'penjualans.nota_id')
            ->join('produks', 'notas.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(notas.quantity) as total_produk_terjual, SUM(notas.quantity * produks.cogs) as total_cogs')
            ->first();

        $totalProdukTerjual = $notaStats->total_produk_terjual ?? 0;
        $totalProdukTerjual -= $totalPengembalianQuantity;
        
        $totalCogs = $notaStats->total_cogs ?? 0;
        $totalCogs -= $totalPengembalianCogs;
        $netProfit = $grossRevenue - $totalCogs;

        $data = Penjualan::with('user')
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->latest()
            ->paginate(10)
            ->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        return view('src.pages.penjualan.index', compact(
            'data', 'startDate', 'endDate',
            'grossRevenue', 'netProfit', 'totalPesanan', 'totalProdukTerjual'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $nota = Nota::with('produk')->where('no_nota', $penjualan->nota_id)->get();
        $penjualan = Penjualan::with('user')->where('id', $penjualan->id)->first();

        return view('src.pages.penjualan.show', compact('nota', 'penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }

    /**
     * Export the filtered resource to PDF.
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ?: now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?: now()->endOfMonth()->toDateString();

        // Calculate Metrics
        $grossRevenue = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->sum('grand_total');
        $totalPesanan = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->count();

        $pengembalianStats = DB::table('pengembalians')
            ->join('produks', 'pengembalians.produk_id', '=', 'produks.id')
            ->whereBetween('pengembalians.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(pengembalians.quantity * produks.price_sell) as total_pengembalian_revenue, SUM(pengembalians.quantity * produks.cogs) as total_pengembalian_cogs, SUM(pengembalians.quantity) as total_pengembalian_quantity')
            ->first();

        $totalPengembalianRevenue = $pengembalianStats->total_pengembalian_revenue ?? 0;
        $totalPengembalianCogs = $pengembalianStats->total_pengembalian_cogs ?? 0;
        $totalPengembalianQuantity = $pengembalianStats->total_pengembalian_quantity ?? 0;

        $grossRevenue -= $totalPengembalianRevenue;

        $notaStats = DB::table('notas')
            ->join('penjualans', 'notas.no_nota', '=', 'penjualans.nota_id')
            ->join('produks', 'notas.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(notas.quantity) as total_produk_terjual, SUM(notas.quantity * produks.cogs) as total_cogs')
            ->first();

        $totalProdukTerjual = $notaStats->total_produk_terjual ?? 0;
        $totalProdukTerjual -= $totalPengembalianQuantity;
        
        $totalCogs = $notaStats->total_cogs ?? 0;
        $totalCogs -= $totalPengembalianCogs;
        $netProfit = $grossRevenue - $totalCogs;

        $data = Penjualan::with('user')
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('src.pages.penjualan.pdf', compact(
            'data', 'startDate', 'endDate',
            'grossRevenue', 'netProfit', 'totalPesanan', 'totalProdukTerjual'
        ));

        return $pdf->download('laporan-penjualan-'.$startDate.'-'.$endDate.'.pdf');
    }
}

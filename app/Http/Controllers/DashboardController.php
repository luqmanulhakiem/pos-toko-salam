<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        // Calculate Metrics for the current month
        $grossRevenue = \App\Models\Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->sum('grand_total');
        $totalPesanan = \App\Models\Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->count();

        $notaStats = \Illuminate\Support\Facades\DB::table('notas')
            ->join('penjualans', 'notas.no_nota', '=', 'penjualans.nota_id')
            ->join('produks', 'notas.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(notas.quantity) as total_produk_terjual, SUM(notas.quantity * produks.cogs) as total_cogs')
            ->first();

        $totalProdukTerjual = $notaStats->total_produk_terjual ?? 0;
        $totalCogs = $notaStats->total_cogs ?? 0;
        $netProfit = $grossRevenue - $totalCogs;

        return view('src.pages.dashboard.index', compact(
            'grossRevenue', 'netProfit', 'totalPesanan', 'totalProdukTerjual'
        ));
    }
}

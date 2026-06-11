<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        // Calculate Metrics for the current month
        $grossRevenue = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->sum('grand_total');
        $totalPesanan = Penjualan::whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])->count();

        $notaStats = DB::table('notas')
            ->join('penjualans', 'notas.no_nota', '=', 'penjualans.nota_id')
            ->join('produks', 'notas.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->selectRaw('SUM(notas.quantity) as total_produk_terjual, SUM(notas.quantity * produks.cogs) as total_cogs')
            ->first();

        $totalProdukTerjual = $notaStats->total_produk_terjual ?? 0;
        $totalCogs = $notaStats->total_cogs ?? 0;
        $netProfit = $grossRevenue - $totalCogs;

        // Chart Data
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;

        $daysInMonth = now()->daysInMonth;

        $currentMonthSales = Penjualan::selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('date')
            ->pluck('total', 'date');

        $lastMonthSales = Penjualan::selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDataCurrent = [];
        $chartDataLast = [];
        $categories = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dateStrCurrent = Carbon::createFromDate($currentYear, $currentMonth, $i)->toDateString();

            $daysInLastMonth = now()->subMonth()->daysInMonth;
            if ($i <= $daysInLastMonth) {
                $dateStrLast = Carbon::createFromDate($lastMonthYear, $lastMonth, $i)->toDateString();
            } else {
                $dateStrLast = null;
            }

            $chartDataCurrent[] = $currentMonthSales->get($dateStrCurrent, 0);
            $chartDataLast[] = $dateStrLast ? $lastMonthSales->get($dateStrLast, 0) : 0;
            $categories[] = $i;
        }

        $recentSales = Penjualan::with('user')->latest()->take(7)->get();

        return view('src.pages.dashboard.index', compact(
            'grossRevenue', 'netProfit', 'totalPesanan', 'totalProdukTerjual',
            'chartDataCurrent', 'chartDataLast', 'categories', 'recentSales'
        ));
    }
}

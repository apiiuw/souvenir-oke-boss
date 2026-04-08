<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->endOfDay()->format('Y-m-d'));

        $query = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->where('status', '!=', 'cancelled');

        $summary = [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_price'),
            'total_items' => $query->sum('total_qty'),
            'avg_order_value' => $query->count() > 0 ? $query->sum('total_price') / $query->count() : 0,
        ];

        $orders = $query->latest()->get();

        return view('roles.admins.reports.index', [
            'title' => 'Laporan Penjualan',
            'summary' => $summary,
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->endOfDay()->format('Y-m-d'));

        $query = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->where('status', '!=', 'cancelled');

        $orders = $query->latest()->get();
        $totalRevenue = $query->sum('total_price');

        $pdf = Pdf::loadView('roles.admins.reports.pdf', [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue
        ]);

        $filename = 'Laporan-Penjualan-' . $startDate . '-to-' . $endDate . '.pdf';
        return $pdf->download($filename);
    }
}

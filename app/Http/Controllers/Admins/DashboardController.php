<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats Overview (Excluding cancelled orders)
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // 2. Growth Calculation (Current vs Previous Month)
        $currentMonthSales = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        $lastMonthSales = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_price');

        $growth = 0;
        if ($lastMonthSales > 0) {
            $growth = (($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100;
        } elseif ($currentMonthSales > 0) {
            $growth = 100;
        }

        // 3. Line Chart Data (Last 6 Months, excluding cancelled)
        $monthlySalesData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('SUM(total_price) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month_num")
            )
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month_num', 'asc')
            ->get();

        $chartLabels = $monthlySalesData->pluck('month')->toArray();
        $chartValues = $monthlySalesData->pluck('total')->toArray();

        // 4. Doughnut Chart (Categories)
        $categoryData = Category::withCount('products')->get();
        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryCounts = $categoryData->pluck('products_count')->toArray();

        // 5. Recent Orders
        $recentOrders = Order::latest()->take(5)->get();

        return view('roles.admins.dashboard.index', [
            'title' => 'Dashboard',
            'stats' => [
                'sales' => $totalSales,
                'orders' => $totalOrders,
                'products' => $totalProducts,
                'categories' => $totalCategories,
                'growth' => (float)$growth
            ],
            'chart' => [
                'labels' => $chartLabels,
                'values' => $chartValues
            ],
            'categories' => [
                'labels' => $categoryLabels,
                'counts' => $categoryCounts
            ],
            'recentOrders' => $recentOrders
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'user')
            ->with(['latestOrder'])
            ->withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        $summaryQuery = User::query()->where('role', 'user');

        return view('roles.admins.customers.index', [
            'title' => 'Data Pelanggan',
            'customers' => $customers,
            'totalCustomers' => (clone $summaryQuery)->count(),
            'activeCustomers' => (clone $summaryQuery)->has('orders')->count(),
            'totalOrders' => (clone $summaryQuery)->withCount('orders')->get()->sum('orders_count'),
        ]);
    }
}

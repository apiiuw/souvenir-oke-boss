<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users\BerandaController;
use App\Http\Controllers\Users\TentangKamiController;
use App\Http\Controllers\Users\ProdukController;
use App\Http\Controllers\Users\CartController;
use App\Http\Controllers\Users\CheckoutController;
use App\Http\Controllers\Users\OrderTrackingController;
use App\Http\Controllers\Users\ProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\StockController;
use App\Http\Controllers\Admins\CategoryController;
use App\Http\Controllers\Admins\ProductController;
use App\Http\Controllers\Admins\OrderController;
use App\Http\Controllers\Admins\ReportController;
use App\Http\Controllers\Admins\CustomerController;


// Users
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentang-kami');
Route::get('/kategori-produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan-saya', [OrderTrackingController::class, 'index'])->name('user.orders.index');
    Route::get('/pesanan-saya/{order}', [OrderTrackingController::class, 'show'])->name('user.orders.show');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('user.profile.update');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.authenticate');
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.store');

    Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('admin.login.authenticate');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admins
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/stock', [StockController::class, 'index'])->name('admin.stock');
    Route::patch('/admin/stock/{product}', [StockController::class, 'update'])->name('admin.stock.update');
    
    // Categories
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::patch('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Products
    Route::resource('/admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::delete('/admin/product-images/{image}', [ProductController::class, 'deleteImage'])->name('admin.products.delete-image');

    // Orders
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Customers
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');

    // Reports
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/pdf', [ReportController::class, 'downloadPdf'])->name('admin.reports.pdf');
});

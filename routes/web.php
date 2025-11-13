<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\ProductController as OwnerProductController;
use App\Http\Controllers\Owner\RevenueController;
use App\Http\Controllers\Owner\CustomerController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Middleware\CheckRole;

// Authentication
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN
Route::middleware([CheckRole::class.':admin'])->group(function () {

    // Dashboard Routes
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Product Routes
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    // Category Routes
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    // Order Routes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('admin.transactions.show');
    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('admin.reports.print');
});

// CUSTOMER
Route::middleware([CheckRole::class.':customer'])->group(function () {

    // Dashboard Routes
    Route::get('/customer/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    // Product Routes
    Route::get('/customer/products', [CustomerProductController::class, 'index'])->name('customer.products');
    // Cart Routes
    Route::get('/customer/cart', [CartController::class, 'index'])->name('customer.cart');
    Route::post('/customer/cart/add', [CartController::class, 'add'])->name('customer.cart.add');
    Route::put('/customer/cart/update/{id}', [CartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/customer/cart/remove/{id}', [CartController::class, 'remove'])->name('customer.cart.remove');
    // Checkout Routes
    Route::post('/customer/checkout', [CheckoutController::class, 'store'])->name('customer.checkout');
    // Order Routes
    Route::get('/customer/orders', [OrderController::class, 'index'])->name('customer.orders');
    Route::post('/customer/orders/cancel/{id}', [OrderController::class, 'cancel'])->name('customer.orders.cancel');
    // Xendit Callback
    Route::post('/xendit/callback', [XenditController::class, 'callback'])->name('xendit.callback');
    Route::get('/customer/payment/success/{order}', [CheckoutController::class, 'success'])->name('customer.payment.success');
    // Profile Route
    Route::get('/customer/profile', [DashboardController::class, 'profile'])->name('customer.profile');
    Route::get('/customer/profile/edit', [DashboardController::class, 'editProfile'])->name('customer.profile.edit');
    Route::post('/customer/profile/update', [DashboardController::class, 'updateProfile'])->name('customer.profile.update');
});

// OWNER
Route::middleware([CheckRole::class.':owner'])->group(function () {

    // Dashboard Routes
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    // Product Routes
    Route::get('/owner/products', [OwnerProductController::class, 'index'])->name('owner.products');
    // Revenue Routes
    Route::get('/owner/revenue', [RevenueController::class, 'index'])->name('owner.revenue');
    // Customer Routes
    Route::get('/owner/customers', [CustomerController::class, 'index'])->name('owner.customers');
});


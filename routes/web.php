<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PickupAndDeliveryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

// 1. Home Route (When opening first: redirect to Login if guest, or Dashboard if authenticated)
Route::get('/', function () {
    if (Auth::check() || session('is_logged_in') === true) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// 2. Guest Routes (Login, Register, Forgot Password)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// 3. Logout Route (Accessible via GET or POST)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 4. Authenticated Application Routes (Protected by Auth: login once, accessible across ALL pages)
Route::middleware('auth')->group(function () {

    // Dashboard Module
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/switch-role/{role}', [DashboardController::class, 'switchRole'])->name('dashboard.switch-role');
    Route::get('/dashboard-preview', [DashboardController::class, 'index'])->name('dashboard.preview');

    // Service Management Module
    Route::resource('services', ServiceController::class);
    Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/services-preview', [ServiceController::class, 'index'])->name('services.preview');

    // Employee Management Module
    Route::resource('employees', EmployeeController::class);
    Route::get('/employees-preview', [EmployeeController::class, 'index'])->name('employees.preview');

    // Customer Management Module
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers-preview', [CustomerController::class, 'index'])->name('customers.preview');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{id}/orders', [CustomerController::class, 'orders'])->name('customers.orders');

    // Laundry Order Management Module
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders-preview', [OrderController::class, 'index'])->name('orders.preview');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/print', [OrderController::class, 'printReceipt'])->name('orders.print');

    // Payment Management Module
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payment-preview', [PaymentController::class, 'index'])->name('payment.preview');
    Route::post('/payment/record', [PaymentController::class, 'recordPayment'])->name('payment.record');
    Route::post('/payment/invoice', [PaymentController::class, 'generateInvoice'])->name('payment.invoice');
    Route::post('/payment/remind', [PaymentController::class, 'sendReminders'])->name('payment.remind');
    Route::get('/payment/export', [PaymentController::class, 'export'])->name('payment.export');
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{id}/refund', [PaymentController::class, 'refund'])->name('payment.refund');
    Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

    // Pickup & Delivery Logistics Module
    Route::get('/pickup-and-delivery', [PickupAndDeliveryController::class, 'index'])->name('pickup-and-delivery.index');
    Route::get('/PickupAndDelivery', [PickupAndDeliveryController::class, 'index'])->name('PickupAndDelivery');
    Route::get('/pickup-delivery', [PickupAndDeliveryController::class, 'index'])->name('pickup-delivery.index');
    Route::post('/pickup-and-delivery/schedule', [PickupAndDeliveryController::class, 'scheduleTask'])->name('pickup-and-delivery.schedule');
    Route::post('/pickup-and-delivery/assign/{id}', [PickupAndDeliveryController::class, 'assignStaff'])->name('pickup-and-delivery.assign');
    Route::get('/pickup-and-delivery/export', [PickupAndDeliveryController::class, 'export'])->name('pickup-and-delivery.export');

    // Report Management Module
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/export/{format}', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/print-view', [ReportController::class, 'printView'])->name('reports.print');
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports-preview', [ReportController::class, 'index'])->name('reports.preview');
    Route::post('/reports-preview', [ReportController::class, 'store'])->name('reports.preview.store');
    Route::put('/reports-preview/{id}', [ReportController::class, 'update'])->name('reports.preview.update');
    Route::delete('/reports-preview/{id}', [ReportController::class, 'destroy'])->name('reports.preview.destroy');
    Route::get('/reports-preview/export/{format}', [ReportController::class, 'export'])->name('reports.preview.export');

    // Machine Management Module
    Route::get('/machines', [MachineController::class, 'index'])->name('machines.index');
    Route::get('/machine', [MachineController::class, 'index'])->name('machine');
    Route::get('/machines-preview', [MachineController::class, 'index'])->name('machines.preview');
    Route::post('/machines', [MachineController::class, 'store'])->name('machines.store');
    Route::put('/machines/{id}', [MachineController::class, 'update'])->name('machines.update');
    Route::delete('/machines/{id}', [MachineController::class, 'destroy'])->name('machines.destroy');
    Route::get('/machines/export/{format}', [MachineController::class, 'export'])->name('machines.export');

    // Inventory Management Module
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
    Route::get('/inventory-preview', [InventoryController::class, 'index'])->name('inventory.preview');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/reset', [InventoryController::class, 'reset'])->name('inventory.reset');
    Route::get('/inventory/export/{format}', [InventoryController::class, 'export'])->name('inventory.export');

    // Notification Management Module
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notifications-preview', [NotificationController::class, 'index'])->name('notifications.preview');
    Route::post('/notifications/broadcast', [NotificationController::class, 'sendBroadcast'])->name('notifications.broadcast');
    Route::post('/notifications/toggle-trigger', [NotificationController::class, 'toggleTrigger'])->name('notifications.toggle');
    Route::post('/notifications/dry-run', [NotificationController::class, 'dryRunSandbox'])->name('notifications.sandbox');

    // Discounts & Promotions Module (Integrated with Machine Dashboard)
    Route::get('/promotions', [MachineController::class, 'promotionsIndex'])->name('promotions.index');
    Route::get('/discounts', [MachineController::class, 'promotionsIndex'])->name('discounts.index');
    Route::post('/promotions', [MachineController::class, 'storePromotion'])->name('promotions.store');
    Route::put('/promotions/{id}', [MachineController::class, 'updatePromotion'])->name('promotions.update');
    Route::delete('/promotions/{id}', [MachineController::class, 'destroyPromotion'])->name('promotions.destroy');
    Route::post('/promotions/{id}/toggle', [MachineController::class, 'togglePromotion'])->name('promotions.toggle');
    Route::post('/promotions/apply', [MachineController::class, 'applyPromotion'])->name('promotions.apply');

    // Settings Module
    Route::get('/settings', function () {
        return view('pages.sitting');
    })->name('settings.index');
    Route::get('/setting', function () {
        return view('pages.sitting');
    })->name('setting');

});
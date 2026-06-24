<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\TicketController;

use App\Http\Controllers\Payment\MidtransController;
use App\Http\Controllers\Payment\MidtransWebhookController;
use App\Http\Controllers\TicketValidationController;

Route::get('/', function () {
    $featuredEvents = Event::query()
        ->where('status', 'active')
        ->with(['ticketCategories' => function ($query) {
            $query->where('status', 'active');
        }])
        ->latest()
        ->take(3)
        ->get();

    return view('landing', compact('featuredEvents'));
})->name('landing');

Route::get('/ticket/validate/{ticketNumber}', [TicketValidationController::class, 'validateTicket'])
    ->name('ticket.validate');

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.webhook');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/events', [UserEventController::class, 'index'])
        ->name('user.events.index');

    Route::get('/events/{event}', [UserEventController::class, 'show'])
        ->name('user.events.show');

    Route::get('/checkout/{ticketCategory}', [CheckoutController::class, 'create'])
        ->name('user.checkout.create');

    Route::post('/checkout/{ticketCategory}', [CheckoutController::class, 'store'])
        ->name('user.checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('user.orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('user.orders.show');

    Route::get('/payment/{order}', [MidtransController::class, 'pay'])
        ->name('user.payment.pay');

    Route::get('/payment/{order}/success', [MidtransController::class, 'success'])
        ->name('user.payment.success');

    Route::get('/payment/{order}/failed', [MidtransController::class, 'failed'])
        ->name('user.payment.failed');

    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])
        ->name('user.tickets.download');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('events', AdminEventController::class);
        Route::resource('tickets', TicketCategoryController::class);

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.export.pdf');

        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])
            ->name('reports.export.excel');
    });

require __DIR__.'/auth.php';

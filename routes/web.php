<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\MajorController;
use App\Http\Controllers\user\DoctorController;
use App\Http\Controllers\user\ContactController;
use App\Http\Controllers\user\ServiceController;
use App\Http\Controllers\user\BookingController;
use App\Http\Controllers\user\ChatBotController;
use App\Http\Controllers\user\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['as' => 'front.'], function () {

    // ── Home ──────────────────────────────────────────────────────────────
    Route::get('/',          [HomeController::class, 'index'])->name('home');
    Route::get('/about-us',  [HomeController::class, 'about'])->name('about');

    // ── Services ──────────────────────────────────────────────────────────
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    // ── Majors ────────────────────────────────────────────────────────────
    Route::get('/majors',        [MajorController::class, 'index'])->name('majors');
    Route::get('/major/{major}', [MajorController::class, 'show'])->name('major.show');

    // ── Doctors ───────────────────────────────────────────────────────────
    Route::get('/doctors',          [DoctorController::class, 'index'])->name('doctors');
    Route::get('/doctor/{doctor}',  [DoctorController::class, 'show'])->name('doctor.show');

    // ── Booking (guests see form, auth required to submit) ────────────────

    // ── chatbot ───────────────────────────────────────────────────────────
    Route::get('/chatbot', [ChatBotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot/send', [ChatBotController::class, 'send'])->name('chatbot.send');
    
    Route::middleware(['auth','verified'])->group(function () {
        // front.profile.my-appointments
        Route::get('/profile/appointments', [HomeController::class, 'appointments'])->name('profile.my-appointments');
        Route::patch('/booking/{booking}/cancel', [HomeController::class, 'cancel'])->name('booking.cancel');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

        // Show booking form
        Route::get('/booking/{doctor}', [BookingController::class, 'create'])->name('booking.create');

        // Store booking → redirects to fake checkout OR success (pay at clinic)
        Route::post('/booking/{doctor}', [BookingController::class, 'store'])->name('booking.store');

        // Fake Stripe checkout page
        Route::get('/booking/{booking}/checkout',[BookingController::class, 'fakeCheckout'])->name('booking.fake-checkout');

        // Simulate payment result (success / fail)
        Route::post('/booking/{booking}/pay-simulate',[BookingController::class, 'simulatePayment'])->name('booking.pay-simulate');

        // Result pages
        Route::get('/booking/{booking}/success',[BookingController::class, 'success'])->name('booking.success');
        Route::get('/booking/{booking}/failed',[BookingController::class, 'failed'])->name('booking.failed');

        // ── Notifications ──────────────────────────────────────────────────
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');


    });

    // ── Contact ───────────────────────────────────────────────────────────
    Route::get('/contact-us',        [ContactController::class, 'index'])->name('contact');
    Route::post('/contact-us/store', [ContactController::class, 'store'])->name('contact.store');

});

require_once __DIR__ . '/auth.php';
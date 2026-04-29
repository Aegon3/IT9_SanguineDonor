<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\BloodInventoryController;
use App\Http\Controllers\Admin\RecipientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\BloodRequestController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Donor\DonorDashboardController;
use App\Http\Controllers\Recipient\RecipientDashboardController;

Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',     [LoginController::class, 'show'])->name('login');
Route::post('/login',    [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',   [LoginController::class, 'logout'])->name('logout');
Route::get('/register',  [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Admin
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Donors
    Route::resource('donors', DonorController::class);

    // Inventory
    Route::resource('inventory', BloodInventoryController::class)->only(['index','edit','update']);

    // Recipients verification
    Route::get('/recipients',                    [RecipientController::class, 'index'])->name('recipients.index');
    Route::post('/recipients/{user}/approve',    [RecipientController::class, 'approve'])->name('recipients.approve');
    Route::post('/recipients/{user}/decline',    [RecipientController::class, 'decline'])->name('recipients.decline');

    // Appointments
    Route::get('/appointments',                  [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create',           [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',                 [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/{appointment}',   [AppointmentController::class, 'update'])->name('appointments.update');

    // Donor verification
    Route::post('/donors/{donor}/approve', [DonorController::class, 'approve'])->name('donors.approve');
    Route::post('/donors/{donor}/decline', [DonorController::class, 'decline'])->name('donors.decline');

    // Donations
    Route::get('/donations',               [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create',        [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations',              [DonationController::class, 'store'])->name('donations.store');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');

    // Blood requests
    Route::get('/blood-requests',                         [BloodRequestController::class, 'index'])->name('blood-requests.index');
    Route::post('/blood-requests/{bloodRequest}/approve', [BloodRequestController::class, 'approve'])->name('blood-requests.approve');
    Route::post('/blood-requests/{bloodRequest}/reject',  [BloodRequestController::class, 'reject'])->name('blood-requests.reject');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// Donor
Route::middleware(['auth','role:donor'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard',                      [DonorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/schedule',                       [DonorDashboardController::class, 'schedule'])->name('schedule');
    Route::post('/schedule',                      [DonorDashboardController::class, 'storeSchedule'])->name('schedule.store');
    Route::post('/schedule/{appointment}/cancel', [DonorDashboardController::class, 'cancelSchedule'])->name('schedule.cancel');
    Route::get('/history',                        [DonorDashboardController::class, 'history'])->name('history');
    Route::get('/profile',                        [DonorDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile',                       [DonorDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Recipient
Route::middleware(['auth','role:recipient'])->prefix('recipient')->name('recipient.')->group(function () {
    Route::get('/dashboard', [RecipientDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('recipient.verified')->group(function () {
        Route::get('/request',     [RecipientDashboardController::class, 'requestBlood'])->name('request');
        Route::post('/request',    [RecipientDashboardController::class, 'storeRequest'])->name('request.store');
        Route::get('/my-requests', [RecipientDashboardController::class, 'myRequests'])->name('my-requests');
    });
});
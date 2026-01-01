<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UstadzController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RapotController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    //Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Santri Management
    Route::resource('santri', SantriController::class);

    // Ustadz Management
    Route::resource('ustadz', UstadzController::class);

    // Schedule Management
    Route::resource('schedule', ScheduleController::class);
    Route::get('/schedule-calendar', [ScheduleController::class, 'calendar'])->name('schedule.calendar');

    //API for AJAX requests
    Route::get('/api/santri-by-class/{classId}', function ($classId) {
        $santris = \App\Models\Santri::where('class_id', $classId)
            ->where('status', 'active')
            ->select('id', 'full_name', 'nis')
            ->get();
        return response()->json($santris);
    });

    // Report Management
    Route::resource('report', ReportController::class);
    Route::post('/report/{report}/publish', [ReportController::class, 'publish'])->name('report.publish');
    Route::get('/rapot', [RapotController::class, 'index'])->name('rapot.index');
    Route::post('/rapot', [RapotController::class, 'store'])->name('rapot.store');
    Route::get('/export-pdf', [RapotController::class, 'exportPdf'])->name('rapot.pdf');

    // Tambahan PDF
    Route::get('/report/{report}/preview', [ReportController::class, 'preview'])->name('report.preview');
    Route::get('/report/{report}/export-pdf', [ReportController::class, 'exportPdf'])->name('report.exportPdf');

    //Dokumen-dokument TPA
    Route::resource('document', DocumentController::class);

    // Absen Management
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
});

<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\MaterialDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/pertemuan/{meeting:slug}', [PublicCourseController::class, 'show'])->name('meetings.show');
Route::get('/materi/{material}/download', [MaterialDownloadController::class, 'download'])->name('materials.download');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', [MeetingController::class, 'index'])->name('dashboard');
        Route::get('/pertemuan/create', [MeetingController::class, 'create'])->name('meetings.create');
        Route::post('/pertemuan', [MeetingController::class, 'store'])->name('meetings.store');
        Route::get('/pertemuan/{meeting}/edit', [MeetingController::class, 'edit'])->name('meetings.edit');
        Route::put('/pertemuan/{meeting}', [MeetingController::class, 'update'])->name('meetings.update');
        Route::patch('/pertemuan/{meeting}/visibility', [MeetingController::class, 'toggleVisibility'])->name('meetings.visibility');
        Route::delete('/pertemuan/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');

        Route::post('/pertemuan/{meeting}/materi', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materi/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    });
});

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\PklRegistrationController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/pendaftar', [App\Http\Controllers\AdminController::class, 'pendaftar'])->name('pendaftar');
    Route::post('/pendaftar/{id}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
    Route::post('/pendaftar/{id}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('reject');
    Route::get('/peserta', [App\Http\Controllers\AdminController::class, 'peserta'])->name('peserta');
    Route::resource('/units', App\Http\Controllers\UnitController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('supervisors', App\Http\Controllers\SupervisorController::class);

    // Letter Template Management
    Route::resource('letter-templates', App\Http\Controllers\LetterTemplateController::class);
    Route::get('letter-templates/{id}/preview', [App\Http\Controllers\LetterTemplateController::class, 'preview'])
        ->name('letter-templates.preview');
    Route::get('letter-templates/{id}/data', [App\Http\Controllers\LetterTemplateController::class, 'getData'])
        ->name('letter-templates.data');

    // Letter Management
    Route::resource('letters', App\Http\Controllers\LetterController::class);
    Route::get('letters/{id}/download', [App\Http\Controllers\LetterController::class, 'download'])
        ->name('letters.download');
    Route::get('api/approved-students', [App\Http\Controllers\LetterController::class, 'getApprovedStudents'])
        ->name('api.approved-students');
});

Route::middleware('auth')->group(function () {
    Route::get('/pendaftaran', [App\Http\Controllers\PklRegistrationController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [App\Http\Controllers\PklRegistrationController::class, 'store'])->name('pendaftaran.store');
    Route::get('/status-pendaftaran', [App\Http\Controllers\PklRegistrationController::class, 'status'])->name('status.index');
    Route::get('/tentang-kami', [App\Http\Controllers\PklRegistrationController::class, 'about'])->name('tentang.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

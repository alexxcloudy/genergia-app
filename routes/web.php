<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CsvDataController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/api/data', [CsvDataController::class, 'getData']);
Route::get('/api/recap/data', [RecapController::class, 'getData']);
Route::post('/api/upload-csv', [FileController::class, 'uploadCsv']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/organizations', function () {
    return Inertia::render('Organizations');
})->middleware(['auth', 'verified'])->name('organizations');

Route::get('/uploadcsv', function () {
    return Inertia::render('SendCsv');
})->middleware(['auth', 'verified'])->name('sendcsv');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

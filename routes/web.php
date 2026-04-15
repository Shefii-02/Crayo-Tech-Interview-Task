<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\FormPublicController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

    Route::get('/form/public/{id}', [FormPublicController::class, 'publicFormShow']);
    Route::post('/form/public/{id}', [FormPublicController::class, 'publicFormSubmit']);

    Route::resource('/forms', FormController::class);
    Route::resource('/users', UserController::class);

    Route::get('/submissions', [SubmissionController::class, 'index']);
    Route::get('/submissions/{id}', [SubmissionController::class, 'show']);
    Route::delete('/submissions/{id}', [SubmissionController::class, 'destroy']);

    Route::get('/import/sample/{form}', [ImportController::class, 'downloadSample']);
    Route::get('/import', [ImportController::class, 'index']);
    Route::post('/import/preview', [ImportController::class, 'preview']);
    Route::post('/import/store', [ImportController::class, 'store']);

    Route::get('/export', [ExportController::class, 'index']);
    Route::get('/export/download', [ExportController::class, 'download']);
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\NewsletterController;

Route::get('/v', function () {
    return view('welcome');
});

Route::get('/dashboard', [SoftwareController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// frontend routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/software/{software}', [HomeController::class, 'detail'])->name('detail');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');

// Admin panel routes
Route::get('/softwares', [SoftwareController::class, 'index'])->name('softwares.index');
Route::get('/softwares/create', [SoftwareController::class, 'create'])->name('softwares.create');
Route::post('/softwares/create/store', [SoftwareController::class, 'store'])->name('softwares.store');
Route::get('/softwares/{software}/edit', [SoftwareController::class, 'edit'])->name('softwares.edit');
Route::put('/softwares/{software}', [SoftwareController::class, 'update'])->name('softwares.update');
Route::delete('/softwares/{software}', [SoftwareController::class, 'destroy'])->name('softwares.destroy');
Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::delete('/newsletter/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');


require __DIR__.'/auth.php';

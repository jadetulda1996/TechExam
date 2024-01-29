<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Thank you
    Route::get('/registered', function () {
        return view('registered');
    });

    // Contact
    Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/contacts/edit/{contact}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::patch('/contacts/edit/{contact}', [ContactController::class, 'update'])->name('contact.update');
    Route::delete('/contacts/delete', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::get('/search', [ContactController::class, 'search'])->name('contact.search');
});

require __DIR__ . '/auth.php';

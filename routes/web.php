<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Routes for Profile CRUD
Route::get('profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('profile/{npm}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index'); // List all profiles
Route::get('profile/{npm}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/{npm}/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile/{npm}/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');


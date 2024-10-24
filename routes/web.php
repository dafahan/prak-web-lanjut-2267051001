<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelasController;


Route::get('/', function () {
    return view('welcome');
});

// Routes for Profile CRUD
Route::get('profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index'); // List all profiles
Route::get('profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile/{id}/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::resource('kelas', KelasController::class);
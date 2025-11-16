<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Routs Admin
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
//Routs User
use App\Http\Controllers\User\DashboardController as UserDashboardController;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $role = Auth::user()->role;
    return $role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    //Routs Admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('role:admin');
    //Routs User
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard')
        ->middleware('role:user');
});
require __DIR__.'/auth.php';

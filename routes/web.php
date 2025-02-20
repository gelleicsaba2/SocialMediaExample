<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckUser;

//

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/verify', [DashboardController::class, 'verify'])->name('verify')->middleware(CheckAdmin::class);
Route::middleware([CheckUser::class])->group(function () {
    Route::get('/people', [RelationController::class, 'index'])->name('people');
    Route::get('/mark', [RelationController::class, 'mark'])->name('people.mark');
    Route::get('/accept', [DashboardController::class, 'accept'])->name('accept');
    Route::get('/refuse', [DashboardController::class, 'refuse'])->name('refuse');
    Route::get('/friends', [FriendsController::class, 'index'])->name('friends');
    Route::get('/view', [FriendsController::class, 'view'])->name('view');
    Route::get('/delete', [FriendsController::class, 'delete'])->name('delete');
});

require __DIR__.'/auth.php';

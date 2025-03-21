<?php

use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\ExpenseCreate;
use App\Livewire\ExpenseReview;
use App\Livewire\Login;
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

Auth::routes();

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/create-expense', ExpenseCreate::class)->name('create-expense');
    Route::get('/review-expense', ExpenseReview::class)->name('review-expense');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

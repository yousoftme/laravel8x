<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/posters', [PosterController::class, 'index'])
                ->name('posters.index');
Route::get('/posters/1', [PosterController::class, 'show'])
                ->name('posters.show');

Route::get('/payment', [PaymentController::class, 'updatePaymentMethod'])->name('update.payment.method');

require __DIR__.'/auth.php';

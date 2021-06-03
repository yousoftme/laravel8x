<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/github/login', function () {
    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $db_user = User::where(['email' => $user->getEmail()])->first();
    if($db_user){
        Auth::login($db_user);
        return redirect()->route('dashboard');
    }else{
        $db_user = User::create([
            'name'          => $user->getName(),
            'email'         => $user->getEmail(),
            'password'      => Hash::make('12345678'),
        ]);
        Auth::login($db_user);
        return redirect()->route('welcome');        
    }
});
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

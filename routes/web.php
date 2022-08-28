<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

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



Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('team',[\App\Http\Controllers\TeamController::class, 'index'])->name('team.index');
    Route::view('/team/add-user', 'users.create')->name('users.create');
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');

    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');
    Route::view('', 'dashboard')->name('home');
//    Route::post('logout', LogoutController::class)
//        ->name('logout');
    Route::get('logout', LogoutController::class)->name('logout');
    Route::get('documents/view/{document}', [\App\Http\Controllers\DocumentController::class, 'show'])->name('documents.show');
});
Route::get('dashboard', [HomeController::class, 'show'])->name('dashboard');

Route::get('/load-logins', function() {
    $users = App\User::withoutGlobalScopes()->whereNotNull('tenant_id')->get();
    foreach($users as $user) {
        \App\Models\Login::factory()->create([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'created_at' => now(),
        ]);
    }
});

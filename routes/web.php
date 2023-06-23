<?php

use App\Http\Controllers\CheckpostController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
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

Route::middleware('login')->group(function () {
    Route::get('/', [UserController::class, 'home'])->name('landing');

    // update route 
    Route::get('update', [UserController::class, 'update'])->name('update');
    Route::post('update', [UserController::class, 'update_data'])->name('update.request');

    // reset two fa 
    Route::get('reset-two-fa', [CheckpostController::class, 'reset_two_fa'])->name('reset.twofa');
});


Route::view('login', 'login')->name('login')->middleware('notLogin');
Route::post('login', [CheckpostController::class, 'login'])->name('login.request');

// registration route 
Route::view('registration', 'registration')->name('signup')->middleware('notLogin');
Route::post('signup-request', [UserController::class, 'create'])->name('signup.request');


// checkpost route 
Route::view('checkpost', 'checkpost')->name('checkpost')->middleware('checkpost');
Route::post('checkpost/next', [CheckpostController::class, 'checkpost'])->name('checkpost.next');



// reset password 
Route::view('password/forgot', 'password.forgot')->name('password.forgot');
Route::post('password/forget', [PasswordController::class, 'check_email'])->name('password.check_email');
Route::view('password/reset', 'password.reset')->name('password.reset')->middleware(['isUser', 'notLogin']);
Route::view('password/update', 'password.update')->name('password.update')->middleware('login');
Route::post('password/update', [PasswordController::class, 'update'])->name('password.update.next');


//Logout route
Route::get('logout', function () {
    session()->flush();
    return redirect()->route('login')->with('notice', 'Logout successfull.');
})->name('logout');

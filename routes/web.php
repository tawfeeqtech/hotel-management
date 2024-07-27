<?php

use App\Http\Controllers\Auth\{ForgotPasswordController,LoginController,RegisterController,ResetPasswordController};
use App\Http\Controllers\{BookingController,CustomerController};
use Illuminate\Support\Facades\{Route,Auth};
use App\Http\Controllers\{HomeController,RoomsController};

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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('home', function () {
        return view('home');
    });
});

Auth::routes();

// -----------------------------home----------------------------------------//
Route::middleware('auth')->controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('/profile', 'profile')->name('profile');
});
// -----------------------------login----------------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});
// ------------------------------ register ---------------------------------//
Route::controller(RegisterController::class)->name('register')->group(function () {
    Route::get('/register', 'register');
    Route::post('/register', 'storeUser');
});

// ----------------------------- forget password ----------------------------//
Route::controller(ForgotPasswordController::class)->name('forget.password')->group(function () {
    Route::get('forget-password', 'getEmail');
    Route::post('forget-password', 'postEmail');
});
// ----------------------------- reset password -----------------------------//
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'getPassword');
    Route::post('reset-password', 'updatePassword');
});

Route::middleware(['auth'])->group(function () {
    // ----------------------------- Booking -----------------------------//
    Route::resource('bookings', BookingController::class)->except('destroy', 'show');
    Route::post('bookings/delete', [BookingController::class, 'destroy'])->name('bookings.delete');

    // ----------------------------- customers -----------------------------//
    Route::resource('customers', CustomerController::class)->except('destroy', 'show');
    Route::post('customers/delete', [CustomerController::class, 'destroy'])->name('customers.delete');

    // ----------------------------- rooms -----------------------------//
    Route::resource('rooms', RoomsController::class)->except('destroy', 'show');
    Route::post('rooms/delete', [RoomsController::class, 'destroy'])->middleware('auth')->name('rooms.delete');
});

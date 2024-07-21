<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Auth;




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

// Route::get('/', [DashboardController::class, 'index']);

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();

// -----------------------------home----------------------------------------//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->middleware('auth')->name('profile');

// -----------------------------login----------------------------------------//
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ------------------------------ register ---------------------------------//
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'storeUser'])->name('register');

// ----------------------------- forget password ----------------------------//
Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('forget-password');

// ----------------------------- reset password -----------------------------//
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword']);
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword']);

// ----------------------------- Booking -----------------------------//
Route::get('bookings', [App\Http\Controllers\BookingController::class, 'index'])->middleware('auth')->name('bookings.index');
Route::get('bookings/edit/{bkg_id}', [App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
Route::get('bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->middleware('auth')->name('bookings.create');

Route::post('bookings/store', [App\Http\Controllers\BookingController::class, 'store'])->middleware('auth')->name('bookings.store');
Route::post('bookings/update', [App\Http\Controllers\BookingController::class, 'update'])->middleware('auth')->name('bookings.update');
Route::post('bookings/delete', [App\Http\Controllers\BookingController::class, 'destroy'])->middleware('auth')->name('bookings.delete');


// ----------------------------- customers -----------------------------//
// Route::get('customers/page', [App\Http\Controllers\CustomerController::class, 'allCustomers'])->middleware('auth')->name('form/allcustomers/page');
// Route::get('form/addcustomer/page', [App\Http\Controllers\CustomerController::class, 'addCustomer'])->middleware('auth')->name('form/addcustomer/page');
// Route::post('form/addcustomer/save', [App\Http\Controllers\CustomerController::class, 'saveCustomer'])->middleware('auth')->name('form/addcustomer/save');
// Route::get('form/customer/edit/{bkg_customer_id}', [App\Http\Controllers\CustomerController::class, 'updateCustomer']);
// Route::post('form/customer/update', [App\Http\Controllers\CustomerController::class, 'updateRecord'])->middleware('auth')->name('form/customer/update');
// Route::post('form/customer/delete', [App\Http\Controllers\CustomerController::class, 'deleteRecord'])->middleware('auth')->name('form/customer/delete');

Route::resource('customers', CustomerController::class)->except('destroy');
Route::post('customers/delete', [CustomerController::class, 'destroy'])->middleware('auth')->name('customers.delete');

Route::resource('rooms', RoomsController::class)->except('destroy');
Route::post('rooms/delete', [RoomsController::class, 'destroy'])->middleware('auth')->name('rooms.delete');


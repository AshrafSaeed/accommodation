<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API Application 
Route::get('/', function(){
    return Response::json(['success' => true,'message' => 'Trivago Accommodation API\'s']);
})->name('application');

// Login
Route::post('/login', [AuthController::class, 'authenticate'])->name('user.login');

// Register
Route::post('/register', [AuthController::class, 'register'])->name('user.register');

// Accommodation Routes
Route::get('accommodation/list', [ItemController::class, 'list'])->name('item.list');
Route::get('accommodation/{slug}', [ItemController::class, 'get'])->name('item.get.byslug');

Route::group([ 'middleware' => 'auth:sanctum'], function() {
    // Accommodation Routes
    Route::ApiResource('accommodation', ItemController::class);

    // Logout Routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
});


// Booking Routes
Route::post('accommodation/booking/create', [BookingController::class, 'create'])->name('booking.create');

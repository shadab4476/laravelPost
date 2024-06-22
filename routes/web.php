<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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



Route::group(['middleware' => ['guest']], function () {
    Route::get('register', [AuthController::class, "registerGet"])->name('register.get');
    Route::post('register', [AuthController::class, "register"])->name('register');
    Route::get('login', [AuthController::class, "loginGet"])->name('login.get');
    Route::get('/', [AuthController::class, "loginGet"])->name('login.get');
    Route::post('login', [AuthController::class, "login"])->name('login');
});

Route::group(["middleware" => ["auth"]], function () {
    Route::get('emailOtp', [AuthController::class, "getVerifyOtp"])->name('getverify.otp');
    Route::post('emailOtp', [AuthController::class, "verifyOtp"])->name('verify.otp');
    Route::post('resendOtp', [AuthController::class, "resendOtp"])->name('resend.otp');
    Route::group(["middleware" => ["emailOtp"]], function () {
        Route::get('/home', [HomeController::class, "index"])->name('home');
        Route::get('logout', [AuthController::class, "logout"])->name('logout');
        // posts
        Route::resource('posts', PostController::class);
        Route::get('posts/category/{id}', [PostController::class, "postCategory"])->name("posts.category.show");
        // categories
        Route::resource('categories', CategoryController::class);
        Route::get('category/posts/{id}', [CategoryController::class, "show"])->name("category.posts.show");
    });
});

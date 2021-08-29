<?php

use App\Http\Controllers;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Category;

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('register-success');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])->name('dashboard-products');
Route::get('/dashboard/products/add', [App\Http\Controllers\DashboardProductController::class, 'add'])->name('dashboard-products-add');
Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])->name('dashboard-products-details');

Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
Route::get('/dashboard/transactions/{id}',[App\Http\Controllers\DashboardTransactionController::class,'details'])->name('dashboard-transactions-details');

Route::get('/dashboard/setting/store',[App\Http\Controllers\DashboardSettingController::class,'store'])->name('dashboard-setting-store');
Route::get('/dashboard/setting/account',[App\Http\Controllers\DashboardSettingController::class,'account'])->name('dashboard-setting-account');

// Admin
// ->middleware(['auth','admin'])

Route::prefix('admin')->namespace('Admin')->group(function(){

        Route::get('/',[DashboardController::class,'index'])->name('admin-dashboard');
        Route::resource('category', '\App\Http\Controllers\Admin\CategoryController');
        // Route::resource('category', 'CategoryController');
    });

Auth::routes();




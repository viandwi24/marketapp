<?php

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

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin\\'
], function () {
    // 
    Route::group([
        'middleware' => 'auth:admin'
    ], function () {
        Route::get('/', function () { return view('pages.admin.home'); })->name('home');
        Route::resource('/category', 'CategoryController')->only(['index', 'store', 'update','destroy']);
        Route::resource('/product', 'ProductController')->only(['index', 'store', 'update','destroy']);
    });

    // 
    Route::group([
        'as' => 'auth.'
    ], function () {
        Route::get('/login', 'AuthController@login')->name('login')->middleware('guest:admin');
        Route::post('/login', 'AuthController@login_post')->name('login.post')->middleware('guest:admin');
        Route::post('/logout', 'AuthController@logout')->name('logout')->middleware('auth:admin');
    });
});


Route::get('/', 'HomeController@index')->name('home');
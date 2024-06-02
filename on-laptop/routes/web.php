<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WebsController;

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
    return view('home');
	// return env("MY_NAME");
});
Route::get("/", [WebsController::class, 'index']);
Route::get("/about", [WebsController::class, 'about']);
Route::get("/home",function(){
	return redirect('/');
}); 

/// 


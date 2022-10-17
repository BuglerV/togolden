<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function(){
	Route::resource('company',\App\Http\Controllers\CompanyApiController::class)
	     ->only(['store','destroy']);
		 
	Route::resource('company.comment',\App\Http\Controllers\CommentApiController::class)
	     ->shallow()
		 ->only(['store','destroy'])
		 ->names([
		   	 'store' => 'comment.store'
		 ]);
});

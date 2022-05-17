<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseholdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Protecting Routes
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/profile', function(Request $request) {
        return Auth::user();
    });

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);

    // Household Managin (incomplete with location)
    Route::get('household/index',[HouseholdController::class,'index']);
    Route::get('household/show/{household}',[HouseholdController::class,'show']);
    Route::post('household/create',[HouseholdController::class,'create']);
    Route::put('household/update/{household}',[HouseholdController::class,'update']);
    Route::delete('household/delete/{household}/',[HouseholdController::class,'delete']);
});
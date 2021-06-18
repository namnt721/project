<?php

use App\Http\Controllers\ApiRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiRegisterController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiPermissionController;


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

Route::post('/register',[ApiRegisterController::class, 'register']);
Route::post('/login',[ApiLoginController::class, 'login']);
Route::get('/check-login',[ApiLoginController::class, 'checkLogin'])->middleware('auth:api');
Route::get('/user-info',[ApiLoginController::class, 'getInfoUser'])->middleware('auth:api');
//User
Route::prefix('user')->group(function () {
    Route::get('/', [ApiUserController::class , 'index']);
    Route::get('/create', [ApiUserController::class , 'create']);
    Route::post('/register', [ApiRegisterController::class , 'register']);
    Route::get('/edit/{id}', [ApiUserController::class , 'edit']);
    Route::post('/update/{id}', [ApiUserController::class , 'update']);
    Route::get('/delete/{id}', [ApiUserController::class , 'delete']);
});
//Category
Route::prefix('category')->group(function () {
    Route::get('/', [ApiCategoryController::class , 'index']);
    Route::post('/create', [ApiCategoryController::class , 'create']);
    Route::get('/edit/{id}', [ApiCategoryController::class , 'edit']);
    Route::post('/update/{id}', [ApiCategoryController::class , 'update']);
    Route::get('/delete/{id}', [ApiCategoryController::class , 'delete']);
});
//Product
Route::prefix('product')->group(function () {
    Route::get('/', [ApiProductController::class , 'index']);
    Route::get('/create', [ApiProductController::class , 'create']);
    Route::post('/store', [ApiProductController::class , 'store']);
    Route::get('/edit/{id}', [ApiProductController::class , 'edit']);
    Route::post('/update/{id}', [ApiProductController::class , 'update']);
    Route::get('/delete/{id}', [ApiProductController::class , 'delete']);
});
//Permission
Route::prefix('permission')->group(function () {
    Route::get('/', [ApiPermissionController::class , 'index']);
    Route::get('/get-permission', [ApiPermissionController::class , 'getPermission']);
    Route::post('/store', [ApiPermissionController::class , 'store']);
    Route::get('/delete/{id}', [ApiPermissionController::class , 'delete']);
});
//Role
Route::prefix('role')->group(function () {
    Route::get('/', [ApiRoleController::class , 'index']);
    Route::get('/create', [ApiRoleController::class , 'create']);
    Route::post('/store', [ApiRoleController::class , 'store']);
    Route::get('/edit/{id}', [ApiRoleController::class , 'edit']);
    Route::post('/update/{id}', [ApiRoleController::class , 'update']);
    Route::get('/delete/{id}', [ApiRoleController::class , 'delete']);
});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

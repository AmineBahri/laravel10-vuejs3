<?php

use App\Http\Controllers\api\AppFontController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\PageController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\PermissionController;
use App\Http\Controllers\api\LangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/reset-password',[AuthController::class,'resetPassword']);
Route::get('/get-i18n',[LangController::class,'getI18n'])->name('getI18n');

Route::group(['middleware'=>['auth:sanctum']],function() {
    Route::get('/user',[AuthController::class,'user']);
    Route::get('/logout',[AuthController::class,'logout']);
    Route::post('/reset-pass',[AuthController::class,'resetPass']);
    Route::post('/user-update',[AuthController::class,'userUpdate']);
    Route::post('/profile-uplaod',[AuthController::class,'profileUplaod']);
    Route::post('/delete-photo',[AuthController::class,'deletePhoto']);
    Route::post('/select-photo',[AuthController::class,'selectPhoto']);
    Route::get('/index-users',[UserController::class,'index']);
    Route::post('/create-user',[UserController::class,'store']);
    Route::get('/get-pages',[PageController::class,'index']);
    Route::post('/create-page',[PageController::class,'store']);
    Route::get('/get-roles',[RoleController::class,'index']);
    Route::post('/create-role',[RoleController::class,'store']);
    Route::get('/get-fonts',[AppFontController::class,'index']);
    Route::post('/create-font',[AppFontController::class,'store']);
    Route::get('/get-permissions/{roleId}',[PermissionController::class,'index']);
    Route::post('/update-permission',[PermissionController::class,'store']);

    Route::post('/add-langs',[LangController::class,'store'])->name('add.langs');
    Route::get('/langs/{key}',[LangController::class,'update'])->name('key.langs');
    Route::get('/langs',[LangController::class,'index'])->name('get.langs');

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::get('/users/{id?}', [UsersApiController::class, 'showUser']);
route::post('/add-user', [UsersApiController::class, 'addUser']);
route::post('/add-multiple-user', [UsersApiController::class, 'addMultipleUser']);
route::put('/update-user/{id}', [UsersApiController::class, 'updateUser']);
route::patch('/update-single-record/{id}', [UsersApiController::class, 'updateUserSingleRecord']);
route::delete('/delete-user/{id}', [UsersApiController::class, 'deleteUser']);
route::delete('/delete-user-json', [UsersApiController::class, 'deleteUserJSON']);

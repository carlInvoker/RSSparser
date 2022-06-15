<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\XMLparserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Models\News;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/newsTest', [XMLparserController::class, 'getXML']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
Route::get('/tokenStatus', [AuthController::class, 'checkIfValidToken']);

Route::get('/news', [NewsController::class, 'getNews']);
Route::get('/news/{news}', [NewsController::class, 'readArticle']);
Route::group([
    'middleware' => 'auth:api',
], function ($router) {
  Route::post('/news', [NewsController::class, 'addArticle']);
  Route::put('/news/{news}', [NewsController::class, 'updateArticle']);
  Route::delete('/news/{news}', [NewsController::class, 'deleteArticle']);
});

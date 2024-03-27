<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostulationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::put('banne', 'updateuserstatus');
    Route::get('displayUser', 'showUsers');

});

Route::controller(EventController::class)->group(function () {
    Route::get('event', 'index');
    Route::post('creatEvent', 'store');
    Route::get('event/{id}', 'show');
    Route::put('event/{id}', 'update');
    Route::delete('event/{id}', 'destroy');
    Route::get('events/search', 'search');
    Route::get('events/postulations', 'postulationsOfEvent');
    Route::get('organisator/events', 'displayEventOfganisator');
}); 


Route::controller(PostulationController::class)->group(function () {
    Route::post('Postulation', 'ctreatePostulation');
    Route::put('accepte', 'accepteReservation');
    Route::get('benevole/postulation', 'showbenevolePostulation');

});

Route::controller(CommentController::class)->group(function () {
    Route::post('Postulation', 'createComment');

});


Route::apiResource('users', AuthController::class );
Route::get('/test', function () {
    return 'iam an API' ;
});
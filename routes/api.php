<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Permissions
Route::get('/permissions', 'App\Http\Controllers\PermissionController@index');
Route::post('/permissions', 'App\Http\Controllers\PermissionController@store');
Route::get('/permissions/{permission}', 'App\Http\Controllers\PermissionController@show');
Route::put('/permissions/{permission}', 'App\Http\Controllers\PermissionController@update');
Route::delete('/permissions/{permission}', 'App\Http\Controllers\PermissionController@destroy');
//Roles
Route::get('/roles', 'App\Http\Controllers\RoleController@index');
Route::post('/roles', 'App\Http\Controllers\RoleController@store');
Route::get('/roles/{role}', 'App\Http\Controllers\RoleController@show');
Route::put('/roles/{role}', 'App\Http\Controllers\RoleController@update');
Route::delete('/roles/{role}', 'App\Http\Controllers\RoleController@destroy');
//Elements
Route::get('/elements', 'App\Http\Controllers\ElementController@index');
Route::post('/elements', 'App\Http\Controllers\ElementController@store');
Route::get('/elements/{element}', 'App\Http\Controllers\ElementController@show');
Route::put('/elements/{element}', 'App\Http\Controllers\ElementController@update');
Route::delete('/elements/{element}', 'App\Http\Controllers\ElementController@destroy');
//Allowed_Elements
Route::get('/allowed_elements', 'App\Http\Controllers\AllowedElementController@index');
Route::post('/allowed_elements', 'App\Http\Controllers\AllowedElementController@store');
Route::get('/allowed_elements/{allowed_Element}', 'App\Http\Controllers\AllowedElementController@show');
Route::put('/allowed_elements/{allowed_Element}', 'App\Http\Controllers\AllowedElementController@update');
Route::delete('/allowed_elements/{allowed_Element}', 'App\Http\Controllers\AllowedElementController@destroy');
//Users
Route::get('/users', 'App\Http\Controllers\UsersController@index');
Route::post('/users', 'App\Http\Controllers\UsersController@store');
Route::get('/users/{users}', 'App\Http\Controllers\UsersController@show');
Route::put('/users/{users}', 'App\Http\Controllers\UsersController@update');
Route::delete('/users/{users}', 'App\Http\Controllers\UsersController@destroy');
//Menu
Route::get('/menu', 'App\Http\Controllers\MenuController@index');
Route::post('/menu', 'App\Http\Controllers\MenuController@store');
Route::get('/menu/{menu}', 'App\Http\Controllers\MenuController@show');
Route::put('/menu/{menu}', 'App\Http\Controllers\MenuController@update');
Route::delete('/menu/{menu}', 'App\Http\Controllers\MenuController@destroy');
//Categories
Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoryController@show');
Route::put('/categories/{category}', 'App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{category}', 'App\Http\Controllers\CategoryController@destroy');
//Teams
Route::get('/teams', 'App\Http\Controllers\TeamController@index');
Route::post('/teams', 'App\Http\Controllers\TeamController@store');
Route::get('/teams/{team}', 'App\Http\Controllers\TeamController@show');
Route::put('/teams/{team}', 'App\Http\Controllers\TeamController@update');
Route::delete('/teams/{team}', 'App\Http\Controllers\TeamController@destroy');
//Players
Route::get('/players', 'App\Http\Controllers\PlayerController@index');
Route::post('/players', 'App\Http\Controllers\PlayerController@store');
Route::get('/players/{player}', 'App\Http\Controllers\PlayerController@show');
Route::put('/players/{player}', 'App\Http\Controllers\PlayerController@update');
Route::delete('/players/{player}', 'App\Http\Controllers\PlayerController@destroy');
//Tournaments
Route::get('/tournaments', 'App\Http\Controllers\TournamentController@index');
Route::post('/tournaments', 'App\Http\Controllers\TournamentController@store');
Route::get('/tournaments/{tournament}', 'App\Http\Controllers\TournamentController@show');
Route::put('/tournaments/{tournament}', 'App\Http\Controllers\TournamentController@update');
Route::delete('/tournaments/{tournament}', 'App\Http\Controllers\TournamentController@destroy');
//Matches
Route::get('/matches', 'App\Http\Controllers\MatcheController@index');
Route::post('/matches', 'App\Http\Controllers\MatcheController@store');
Route::get('/matches/{matche}', 'App\Http\Controllers\MatcheController@show');
Route::put('/matches/{matche}', 'App\Http\Controllers\MatcheController@update');
Route::delete('/matches/{matche}', 'App\Http\Controllers\MatcheController@destroy');
//Match_Results
Route::get('/match_results', 'App\Http\Controllers\MatchResultsController@index');
Route::post('/match_results', 'App\Http\Controllers\MatchResultsController@store');
Route::get('/match_results/{match_Results}', 'App\Http\Controllers\MatchResultsController@show');
Route::put('/match_results/{match_Results}', 'App\Http\Controllers\MatchResultsController@update');
Route::delete('/match_results/{match_Results}', 'App\Http\Controllers\MatchResultsController@destroy');
//Clasifications
Route::get('/clasifications', 'App\Http\Controllers\ClasificationController@index');
//Payment_reasons
Route::get('/payment_reasons', 'App\Http\Controllers\PaymentReasonController@index');
Route::post('/payment_reasons', 'App\Http\Controllers\PaymentReasonController@store');
Route::get('/payment_reasons/{payment_Reason}', 'App\Http\Controllers\PaymentReasonController@show');
Route::put('/payment_reasons/{payment_Reason}', 'App\Http\Controllers\PaymentReasonController@update');
Route::delete('/payment_reasons/{payment_Reason}', 'App\Http\Controllers\PaymentReasonController@destroy');
//Payments
Route::get('/payments', 'App\Http\Controllers\PaymentController@index');
Route::post('/payments', 'App\Http\Controllers\PaymentController@store');
Route::get('/payments/{payment}', 'App\Http\Controllers\PaymentController@show');
Route::put('/payments/{payment}', 'App\Http\Controllers\PaymentController@update');
Route::delete('/payments/{payment}', 'App\Http\Controllers\PaymentController@destroy');
//Transactions
Route::get('/transactions', 'App\Http\Controllers\TransactionController@index');
Route::post('/transactions', 'App\Http\Controllers\TransactionController@store');
Route::get('/transactions/{transaction}', 'App\Http\Controllers\TransactionController@show');
Route::delete('/transactions/{transaction}', 'App\Http\Controllers\TransactionController@destroy');
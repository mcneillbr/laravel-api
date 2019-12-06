<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('clientes')->group(function () {
    Route::get('/', 'ClientController@index')->name('api.cliente.home');
    Route::get('listar', 'ClientController@index')->name('api.cliente.listar');
    Route::post('criar', 'ClientController@store')->name('api.cliente.store');
    Route::get('/{cod_cliente}', 'ClientController@show')->name('api.cliente.show')->where('cod_cliente', '[0-9]+');
    Route::match(['put', 'patch'], '/{cod_cliente}', 'ClientController@update')->name('api.cliente.update')->where('cod_cliente', '[0-9]+');
    Route::delete('/{cod_cliente}', 'ClientController@destroy')->name('api.cliente.delete')->where('cod_cliente', '[0-9]+');
});

Route::prefix('pasteis')->group(function () {
    Route::get('/', 'PastelController@index')->name('api.pasteis.home');
    Route::get('listar', 'PastelController@index')->name('api.pasteis.listar');
    Route::post('criar', 'PastelController@store')->name('api.pasteis.store');
    Route::get('/{cod_pastel}', 'PastelController@show')->name('api.pasteis.show')->where('cod_pastel', '[0-9]+');
    Route::match(['put', 'patch'], '/{cod_pastel}', 'PastelController@update')->name('api.pasteis.update')->where('cod_pastel', '[0-9]+');
    Route::delete('/{cod_pastel}', 'PastelController@destroy')->name('api.pasteis.delete')->where('cod_pastel', '[0-9]+');
});


Route::prefix('ordens')->group(function () {
    Route::get('/', 'OrderController@index')->name('api.ordens.home');
    Route::get('listar', 'OrderController@index')->name('api.ordens.listar');
    Route::post('criar', 'OrderController@store')->name('api.ordens.store');
    Route::get('/{cod_ordem}', 'OrderController@show')->name('api.ordens.show')->where('cod_ordem', '[0-9]+');
    Route::match(['put', 'patch'], '/{cod_ordem}', 'OrderController@update')->name('api.ordens.update')->where('cod_ordem', '[0-9]+');
    Route::delete('/{cod_ordem}', 'OrderController@destroy')->name('api.ordens.delete')->where('cod_ordem', '[0-9]+');
});

Route::get('/health', function(Request $request) {
    $response = new stdClass;
    $response->code = 200;
    $response->state = 'success';
    $response->version = '1.0';
    $response->data = $request->all();
    return response()->json($response, $response->code);
});

$fallbackAction = function(Request $request){
    return response()->json([
        'message' => 'resource not found. If error persists, contact info@api.error'], 404);
};

Route::any('{fallbackPlaceholder?}', $fallbackAction)->where('fallbackPlaceholder', '.*')->name('api.fallback.any')->fallback();

Route::fallback($fallbackAction)->name('api.fallback.resource');


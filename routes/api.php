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

Route::post('/login', function(Request $request) {
	$data = $request->validate([
		'email' => ["required", "email"],
		"password" => ["required"],
	]);

	if(!auth()->attempt($data)) {
		return errorResponse('Invalid cridential', 401);
	}

	$accessToken = auth()->user()->createToken(env('SANCTUM_DEFAULT_NAME'), [
		'pelanggan:read', 'pelanggan:create', 'pelanggan:update', 'pelanggan:delete',
		'barang:read', 'barang:create', 'barang:update', 'barang:delete',
		'penjualan:read', 'penjualan:create', 'penjualan:update', 'penjualan:delete',
		'item_penjualan:read', 'item_penjualan:create', 'item_penjualan:update', 'item_penjualan:delete',
	]);

	return successResponse([
		'token' => $accessToken->plainTextToken
	]);
});

Route::group(['middleware' => ['auth:sanctum', 'cors', 'json.response'] ], function() {
	Route::namespace('App\Http\Controllers\Data')->group(function() {
		Route::prefix('pelanggan')->group(function() {
			Route::post('/', 'PelangganController@index')->middleware('abilities:pelanggan:read');
			Route::post('/store', 'PelangganController@store');
			Route::put('/update/{pelanggan}', 'PelangganController@update');
			Route::delete('/delete/{pelanggan}', 'PelangganController@destroy')->middleware('abilities:pelanggan:delete');
		});

		Route::prefix('barang')->group(function() {
			Route::post('/', 'BarangController@index')->middleware('abilities:barang:read');
			Route::post('/store', 'BarangController@store');
			Route::put('/update/{barang}', 'BarangController@update');
			Route::delete('/delete/{barang}', 'BarangController@destroy')->middleware('abilities:barang:delete');
		});

		Route::prefix('penjualan')->group(function() {
			Route::post('/', 'PenjualanController@index')->middleware('abilities:penjualan:read,item_penjualan:read');
			Route::post('/store', 'PenjualanController@store');
			Route::put('/update/{penjualan}', 'PenjualanController@update');
			Route::delete('/delete/{penjualan}', 'PenjualanController@destroy')->middleware('abilities:penjualan:delete,item_penjualan:delete');
			Route::post('/detail/{penjualan}', 'ItemPenjualanController@index')->middleware('abilities:item_penjualan:read');
		});

		route::prefix('item-penjualan')->group(function() {
			Route::post('/store/{penjualan}', 'ItemPenjualanController@store');
			Route::put('/update/{nota}/{kodeBarang}', 'ItemPenjualanController@update');
			Route::delete('/delete/{nota}/{kodeBarang}', 'ItemPenjualanController@destroy')->middleware('abilities:item_penjualan:delete');
		});
	});
});
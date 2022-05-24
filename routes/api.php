<?php

use App\Http\Resources\User\UserResource;
use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
	
	try {
		$user = auth()->user();

		$accessToken = createUserToken($user);

		return successResponse([
			'user' => new UserResource($user),
			'token' => $accessToken->plainTextToken
		]);
	} catch (\Exception $e) {
		Log::info($e);
		return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
	}
});

Route::group(['middleware' => ['auth:sanctum', 'cors', 'json.response'] ], function() {
	Route::post('/logout', function(Request $request) {
		try {
			$user = $request->user();
			deleteCurrentToken($user);

			return successResponse();
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	});

	Route::namespace('App\Http\Controllers\Akun')->group(function() {
		Route::prefix('akun')->group(function() {
			Route::put('/ubah/profil', 'AkunController@updateAccount');
			Route::put('/ubah/kata-sandi', 'AkunController@changePassword');
			Route::post('/generate-new-token', 'AkunController@generateNewToken');
		});
	});

	Route::namespace('App\Http\Controllers\Data')->group(function() {
		Route::prefix('pelanggan')->group(function() {
			Route::post('/', 'PelangganController@index')->middleware('abilities:pelanggan:read');
			Route::post('/store', 'PelangganController@store');
			Route::get('/edit/{pelanggan}', 'PelangganController@edit');
			Route::put('/update/{pelanggan}', 'PelangganController@update');
			Route::delete('/delete/{pelanggan}', 'PelangganController@destroy')->middleware('abilities:pelanggan:delete');
		});

		Route::prefix('barang')->group(function() {
			Route::post('/', 'BarangController@index')->middleware('abilities:barang:read');
			Route::post('/store', 'BarangController@store');
			Route::get('/edit/{barang}', 'BarangController@edit');
			Route::put('/update/{barang}', 'BarangController@update');
			Route::delete('/delete/{barang}', 'BarangController@destroy')->middleware('abilities:barang:delete');
			Route::get('/list', function() {
				return successResponse(Barang::listData());
			});
		});

		Route::prefix('penjualan')->group(function() {
			Route::post('/', 'PenjualanController@index')->middleware('abilities:penjualan:read,item_penjualan:read');
			Route::post('/store', 'PenjualanController@store');
			Route::get('/edit/{penjualan}', 'PenjualanController@edit');
			Route::put('/update/{penjualan}', 'PenjualanController@update');
			Route::delete('/delete/{penjualan}', 'PenjualanController@destroy')->middleware('abilities:penjualan:delete,item_penjualan:delete');
			Route::post('/detail/{penjualan}', 'ItemPenjualanController@index')->middleware('abilities:item_penjualan:read');
		});

		route::prefix('item-penjualan')->group(function() {
			Route::post('/store/{penjualan}', 'ItemPenjualanController@store');
			Route::get('/edit/{nota}/{kodeBarang}', 'ItemPenjualanController@edit');
			Route::put('/update/{nota}/{kodeBarang}', 'ItemPenjualanController@update');
			Route::delete('/delete/{nota}/{kodeBarang}', 'ItemPenjualanController@destroy')->middleware('abilities:item_penjualan:delete');
			Route::get('/master', function() {
				return successResponse([
					'pelanggan' => Pelanggan::orderBy('nama', 'ASC')->pluck('nama', 'id_pelanggan'),
					'barang' => Barang::listData(),
				]);
			});
		});
	});
});
<?php

use Illuminate\Support\Facades\Redis;

if(! function_exists('jsonResponse')) {
	function successResponse($message = null) {
		$results = [
			"success" => true,
			"results" => $message
		];

		return response()->json($results, 200);
	}
}

if(! function_exists('errorResponse')) {
	function errorResponse($message = null, $code = 500) {
		$results = [
			"success" => false,
			"message" => $message
		];
		
		return response()->json($results, $code);
	}
}

if(! function_exists('incrementId')) {
	function incrementId($key) {
		$newId = 1;

		$result = Redis::get($key);
		
		if($result) {
			$newId += $result;
		}
		
		Redis::set($key, $newId);

		return $key.'_'.$newId;
	}
}

if(! function_exists('decrementId')) {
	function decrementId($key) {
		$result = Redis::get($key);
		
		if($result) {
			$result -= 1;
			Redis::set($key, $result);
		}
	}
}

if(! function_exists('createUserToken')) {
	function createUserToken($user) {
		return $user->createToken(env('SANCTUM_DEFAULT_NAME'), [
    		'pelanggan:read', 'pelanggan:create', 'pelanggan:update', 'pelanggan:delete',
    		'barang:read', 'barang:create', 'barang:update', 'barang:delete',
    		'penjualan:read', 'penjualan:create', 'penjualan:update', 'penjualan:delete',
    		'item_penjualan:read', 'item_penjualan:create', 'item_penjualan:update', 'item_penjualan:delete',
    	]);
	}
}

if(! function_exists('deleteCurrentToken')) {
	function deleteCurrentToken($user) {
		$user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
	}
}
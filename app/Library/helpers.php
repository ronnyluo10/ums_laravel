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
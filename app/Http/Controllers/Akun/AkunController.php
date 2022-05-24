<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\UpdateKataSandiRequest;
use App\Http\Requests\Akun\UpdateProfilRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AkunController extends Controller
{
    public function updateAccount(UpdateProfilRequest $request)
    {
    	try {
    		$request->user()->update([
    			'name' => trim($request->nama),
    			'email' => trim($request->email),
    		]);

    		return successResponse();
    	} catch (\Exception $e) {
    		Log::info($e);
    		return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
    	}
    }

    public function changePassword(UpdateKataSandiRequest $request)
    {
    	try {
    		$request->user()->update([
    			'password' => bcrypt($request->kata_sandi_baru),
    		]);

    		return successResponse();
    	} catch (\Exception $e) {
    		Log::info($e);
    		return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
    	}
    }

    public function generateNewToken(Request $request)
    {
    	try {
    		$user = $request->user();
    		deleteCurrentToken($user);
    		// $user->tokens()->delete();

    		return successResponse([
    			'user' => new UserResource($user),
				'token' => createUserToken($user)->plainTextToken,
    		]);
    	} catch (\Exception $e) {
    		Log::info($e);
    		return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
    	}
    }
}

<?php

namespace App\Library\Repository\Pelanggan;

use App\Http\Resources\Pelanggan\PelangganResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Library\Vendor\Datatables\Facades\Datatables;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;

class PelangganRepository implements CRUDInterface
{
	public function create(object $request): object
	{
		try {
			$pelanggan = new Pelanggan;
			$pelanggan->id_pelanggan = incrementId('pelanggan');
			$pelanggan->nama = $request->nama;
			$pelanggan->domisili = $request->domisili;
			$pelanggan->jenis_kelamin = $request->jenis_kelamin;
			$pelanggan->save();

			return successResponse($pelanggan);
		} catch (\Exception $e) {
			decrementId('pelanggan');
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function read(object $model = null): object
	{
		try {
			return successResponse(Datatables::of(Pelanggan::query(), PelangganResource::class));
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function update(object $request, object $model): object
	{
		try {
			$model->nama = $request->nama;
			$model->domisili = $request->domisili;
			$model->jenis_kelamin = $request->jenis_kelamin;
			$model->save();

			return successResponse($model);
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function delete(object $model): object
	{
		try {
			$model->delete();

			return successResponse();
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}
}
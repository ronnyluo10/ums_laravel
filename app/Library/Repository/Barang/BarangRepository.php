<?php

namespace App\Library\Repository\Barang;

use App\Http\Resources\Barang\BarangResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Library\Vendor\Datatables\Facades\Datatables;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

class BarangRepository implements CRUDInterface
{
	public function create(object $request): object
	{
		try {
			$barang = new Barang;
			$barang->kode = incrementId('brg');
			$barang->nama = $request->nama;
			$barang->kategori = $request->kategori;
			$barang->harga = (int) str_replace(".", "", $request->harga);
			$barang->save();

			return successResponse($barang);
		} catch (\Exception $e) {
			decrementId('brg');
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function read(object $model = null): object
	{
		try {
			return successResponse(Datatables::of(Barang::query(), BarangResource::class));
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function update(object $request, object $model): object
	{
		try {
			$model->nama = $request->nama;
			$model->kategori = $request->kategori;
			$model->harga = (int) str_replace(".", "", $request->harga);
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
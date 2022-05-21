<?php

namespace App\Library\Repository\Penjualan;

use App\Http\Resources\Penjualan\PenjualanResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Library\Vendor\Datatables\Facades\Datatables;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanRepository implements CRUDInterface
{
	public function create(object $request): object
	{
		DB::beginTransaction();
		try {
			$subtotal = 0;
			$temps = [];
			$nota = incrementId('nota');

			foreach ($request->barang as $key => $value) {
				$barang = Barang::find($value);
				$subtotal += $barang->harga * $request->qty[$key];

				$temps[] = [
					"nota" => $nota,
					"kode_barang" => $barang->kode,
					"qty" => $request->qty[$key],
					"created_at" => now()->format('Y-m-d H:i:s'),
					"updated_at" => now()->format('Y-m-d H:i:s'),
				];
			}

			$penjualan = new Penjualan;
			$penjualan->id_nota = $nota;
			$penjualan->tgl = $request->tgl;
			$penjualan->kode_pelanggan = $request->pelanggan;
			$penjualan->subtotal = $subtotal;
			$penjualan->save();

			$penjualan->itemPenjualan()->insert($temps);

			DB::commit();

			return successResponse($penjualan);
		} catch (\Exception $e) {
			DB::rollBack();
			decrementId('penjualan');
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function read(object $model = null): object
	{
		try {
			return successResponse(Datatables::of(Penjualan::with(['itemPenjualan', 'itemPenjualan.barang']), PenjualanResource::class));
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function update(object $request, object $model): object
	{
		try {
			$model->tgl = $request->tgl;
			$model->kode_pelanggan = $request->pelanggan;
			$model->subtotal = $request->subtotal;
			$model->save();

			return successResponse($model);
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function delete(object $model): object
	{
		DB::beginTransaction();
		
		try {
			$model->delete();
			
			decrementId('nota');

			DB::commit();

			return successResponse();
		} catch (\Exception $e) {
			DB::rollBack();
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}
}
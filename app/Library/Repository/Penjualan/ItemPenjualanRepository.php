<?php

namespace App\Library\Repository\Penjualan;

use App\Http\Resources\Penjualan\ItemPenjualanResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Library\Vendor\Datatables\Facades\Datatables;
use App\Models\Barang;
use App\Models\ItemPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemPenjualanRepository implements CRUDInterface
{
	public function create(object $request): object
	{
		DB::beginTransaction();

		try {
			$penjualan = $request->penjualan;

			$penjualan->itemPenjualan()->create([
				'kode_barang' => $request->kode_barang,
				'qty' => $request->qty,
			]);

			$barang = Barang::find($request->kode_barang);
			$price = $barang->harga * $request->qty;

			$penjualan->subtotal = $penjualan->subtotal + $price;
			$penjualan->save();

			DB::commit();

			return successResponse($penjualan);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function read(object $model = null): object
	{
		try {
			return successResponse(Datatables::of(ItemPenjualan::with('barang')->where('nota', $model->id_nota), ItemPenjualanResource::class));
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function update(object $request, object $model): object
	{
		try {
			$result = $model->first();

			if(!$result) throw new \Exception("Data not found");

		} catch (\Exception $e) {
			return errorResponse($e->getMessage(), 400);
		}

		DB::beginTransaction();
		
		try {

			$decrementSubtotal = $this->getSubtotal();

			$model->update([
				'kode_barang' => $request->kode_barang,
				'qty' => $request->qty,
			]);
			
			$barang = Barang::where('kode', $request->kode_barang)->first();

			$newSubtotal = ($barang->harga * $request->qty) + $decrementSubtotal;

			$result->penjualan()->update([
				'subtotal' => $newSubtotal,
			]);

			DB::commit();

			return successResponse($model);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	public function delete(object $model): object
	{
		try {
			$result = $model->first();

			$newSubtotal = $this->getSubtotal($result);
			
			$result->penjualan()->update([
				'subtotal' => $newSubtotal,
			]);

			$model->delete();

			return successResponse();
		} catch (\Exception $e) {
			Log::info($e);
			return errorResponse(env('INTERNAL_SERVER_ERROR_MSG'), 500);
		}
	}

	protected function getSubtotal($result)
	{
		$currentSubTotal = $result->penjualan->subtotal;

		$currentPrice = $result->barang->harga * $result->qty;

		return $currentSubTotal - $currentPrice;
	}
}
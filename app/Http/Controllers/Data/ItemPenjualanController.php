<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penjualan\StoreItemPenjualanRequest;
use App\Http\Requests\Penjualan\UpdateItemPenjualanRequest;
use App\Http\Resources\Penjualan\ItemPenjualanResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;

class ItemPenjualanController extends Controller
{
    private $action;

	public function __construct(CRUDInterface $action)
	{
		$this->action = $action;
	}

    public function index(Penjualan $penjualan)
    {
    	return $this->action->read($penjualan);
    }

    public function store(StoreItemPenjualanRequest $request, Penjualan $penjualan)
    {
    	return $this->action->create($request);	
    }

    public function edit(ItemPenjualan $itemPenjualan)
    {
    	return successResponse(new ItemPenjualanResource($itemPenjualan));
    }

    public function update(UpdateItemPenjualanRequest $request, $nota, $kodeBarang)
    {
    	$itemPenjualan = ItemPenjualan::item($nota, $kodeBarang);

    	return $this->action->update($request, $itemPenjualan);
    }

    public function destroy($nota, $kodeBarang)
    {
    	$itemPenjualan = ItemPenjualan::item($nota, $kodeBarang);

    	return $this->action->delete($itemPenjualan);
    }
}

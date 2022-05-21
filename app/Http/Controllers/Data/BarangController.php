<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Barang\StoreBarangRequest;
use App\Http\Requests\Barang\UpdateBarangRequest;
use App\Http\Resources\Barang\BarangResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Models\Barang;

class BarangController extends Controller
{
    private $action;

	public function __construct(CRUDInterface $action)
	{
		$this->action = $action;
	}

    public function index()
    {
    	return $this->action->read();
    }

    public function store(StoreBarangRequest $request)
    {
    	return $this->action->create($request);
    }

    public function edit(Barang $barang)
    {
    	return successResponse(new BarangResource($barang));
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
    	return $this->action->update($request, $barang);
    }

    public function destroy(Barang $barang)
    {
    	return $this->action->delete($barang);
    }
}

<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penjualan\StorePenjualanRequest;
use App\Http\Requests\Penjualan\UpdatePenjualanRequest;
use App\Http\Resources\Penjualan\PenjualanResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
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

    public function store(StorePenjualanRequest $request)
    {
    	return $this->action->create($request);
    }

    public function edit(Penjualan $penjualan)
    {
    	return successResponse(new PenjualanResource($penjualan));
    }

    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
    	return $this->action->update($request, $penjualan);
    }

    public function destroy(Penjualan $penjualan)
    {
    	return $this->action->delete($penjualan);
    }
}

<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pelanggan\StorePelangganRequest;
use App\Http\Requests\Pelanggan\UpdatePelangganRequest;
use App\Http\Resources\Pelanggan\PelangganResource;
use App\Library\Repository\Contracts\CRUDInterface;
use App\Models\Pelanggan;

class PelangganController extends Controller
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

    public function store(StorePelangganRequest $request)
    {
    	return $this->action->create($request);
    }

    public function edit(Pelanggan $pelanggan)
    {
    	return successResponse(new PelangganResource($pelanggan));
    }

    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
    	return $this->action->update($request, $pelanggan);
    }

    public function destroy(Pelanggan $pelanggan)
    {
    	return $this->action->delete($pelanggan);
    }
}

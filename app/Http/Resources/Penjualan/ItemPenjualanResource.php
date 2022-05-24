<?php

namespace App\Http\Resources\Penjualan;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemPenjualanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "nota" => $this->nota,
            "nota_value" => encrypt($this->nota),
            "kode_barang" => $this->kode_barang,
            "qty" => $this->qty,
            "created_at" => $this->created_at->format('d-m-Y H:i:s'),
            "updated_at" => $this->updated_at->format('d-m-Y H:i:s'),
            "barang" => $this->barang,
            "penjualan" => $this->penjualan,
        ];
    }
}

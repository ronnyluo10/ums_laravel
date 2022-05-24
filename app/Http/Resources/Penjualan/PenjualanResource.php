<?php

namespace App\Http\Resources\Penjualan;

use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
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
            "id" => encrypt($this->id_nota),
            "id_nota" => $this->id_nota,
            "tgl" => $this->tgl->format('d-m-Y'),
            "form_date" => $this->tgl->format('Y-m-d'),
            "kode_pelanggan" => $this->kode_pelanggan,
            "subtotal" => number_format(str_replace(".00", "", $this->subtotal), 0, "", "."),
            "item" => $this->itemPenjualan,
            "created_at" => $this->created_at->format('d-m-Y H:i:s'),
            "updated_at" => $this->updated_at->format("d-m-Y H:i:s"),
        ];
    }
}

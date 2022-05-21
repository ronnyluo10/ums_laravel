<?php

namespace App\Http\Resources\Barang;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
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
            "id" => encrypt($this->kode),
            "kode" => $this->kode,
            "nama" => $this->nama,
            "kategori" => $this->kategori,
            "harga" => $this->harga,
            "created_at" => $this->created_at->format('d-m-Y H:i:s'),
            "updated_at" => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}

<?php

namespace App\Http\Resources\Pelanggan;

use Illuminate\Http\Resources\Json\JsonResource;

class PelangganResource extends JsonResource
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
            "id" => encrypt($this->id_pelanggan),
            "nama" => $this->nama,
            "domisili" => $this->domisili,
            "jenis_kelamin" => $this->jenis_kelamin,
            "created_at" => $this->created_at->format('d-m-Y H:i:s'),
            "updated_at" => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}

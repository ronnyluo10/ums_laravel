<?php

namespace App\Http\Requests\Penjualan;

use Illuminate\Foundation\Http\FormRequest;

class StorePenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tokenCan('penjualan:create') && auth()->user()->tokenCan('item_penjualan:create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "tgl" => ["required", "date_format:Y-m-d"],
            "pelanggan" => ["required", "max:15"],
            "barang" => ["required", "array"],
            "barang.*" => ["required", "max:10"],
            "qty" => ["required", "array"],
            "qty.*" => ["required", "numeric", "max:9999999"],
        ];
    }
}

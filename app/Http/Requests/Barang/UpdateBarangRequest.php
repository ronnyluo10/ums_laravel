<?php

namespace App\Http\Requests\Barang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tokenCan('barang:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nama" => ["required", "max:20"],
            "kategori" => ["required", "max:10", "regex:/^[a-zA-Z ]+$/u"],
            "harga" => ["required", "max:9999999", "regex:/^[0-9]{1,3}(.[0-9]{3})*\.[0-9]+$/"],
        ];
    }
}

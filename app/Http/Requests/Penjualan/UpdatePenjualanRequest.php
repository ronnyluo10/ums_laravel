<?php

namespace App\Http\Requests\Penjualan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tokenCan('penjualan:update');
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
            "subtotal" => ["required", "max:9999999", "regex:/^[0-9]{1,3}(.[0-9]{3})*\.[0-9]+$/"],
        ];
    }
}

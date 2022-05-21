<?php

namespace App\Http\Requests\Pelanggan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tokenCan('pelanggan:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nama" => ["required", "max:20", "regex:/^[a-zA-Z ]+$/u"],
            "domisili" => ["required", "max:15"],
            "jenis_kelamin" => ["required", "max:6"],
        ];
    }
}

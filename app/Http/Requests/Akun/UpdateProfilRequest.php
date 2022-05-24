<?php

namespace App\Http\Requests\Akun;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nama" => ["required", "max:50", "regex:/^[a-zA-Z ]+$/u"],
            "email" => ["required", "max:100", "email:rfc,dns"],
        ];
    }
}

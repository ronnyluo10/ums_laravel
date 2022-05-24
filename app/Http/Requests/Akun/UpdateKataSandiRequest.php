<?php

namespace App\Http\Requests\Akun;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKataSandiRequest extends FormRequest
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
            "kata_sandi_sekarang" => ["required", new MatchOldPassword],
            "kata_sandi_baru" => ["required", "min:8"],
            "konfirmasi_kata_sandi" => ["same:kata_sandi_baru"]
        ];
    }
}

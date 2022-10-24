<?php

namespace App\Http\Requests\API\Absensi;

use Illuminate\Foundation\Http\FormRequest;

class AbsenMasukRequest extends FormRequest
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
            'keterangan_absen_masuk' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'keterangan_absen_masuk.required' => 'Keterangan absen masuk tidak boleh kosong!',
        ];
    }
}

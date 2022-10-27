<?php

namespace App\Http\Requests\API\ManagementReport;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
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
            'user_id' => 'required',
            'tanggal' => 'required',
            'absen_masuk' => 'required',
            'keterangan_absen_masuk' => 'required',
            'absen_pulang' => 'required',
            'keterangan_absen_pulang' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => "user id tidak boleh kosong!",
            'tanggal.required' => 'tanggal tidak boleh kosong!',
            'absen_masuk.required' => 'absen masuk tidak boleh kosong!',
            'keterangan_absen_masuk.required' => 'keterangan absen masuk tidak boleh kosong!',
            'absen_pulang.required' => 'absen pulang tidak boleh kosong!',
            'keterangan_absen_pulang.required' => 'keterangan absen pulang tidak boleh kosong!',
        ];
    }
}

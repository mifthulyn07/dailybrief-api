<?php

namespace App\Http\Requests\API\ManagementReport;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAbsensiRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'tanggal' => 'nullable|date_format:Y/m/d',
            'absen_masuk' => 'nullable|date_format:H:i:s',
            'keterangan_absen_masuk' => 'nullable',
            'status_absen_masuk' => 'nullable|in:Hadir,Absen',
            'keterlambatan_absen_masuk' => 'date_format:H:i:s',
            'absen_pulang' => 'nullable|date_format:H:i:s',
            'keterangan_absen_pulang' => 'nullable',
            'status_absen_pulang' => 'nullable|in:Hadir,Absen',
            'keterlambatan_absen_pulang' => 'date_format:H:i:s',
        ];
    }
    public function messages()
    {
        return [
            'user_id' => [
                'exists' => 'user yang di pilih tidak valid!'
            ],
            'tanggal' => [
                'date_format' => 'Format tanggal tidak sama dengan format Y/m/d!',
            ],
            'absen_masuk' => [
                'date_format' => 'Format absen masuk tidak sama dengan format H:i:s!',
            ],
            'keterangan_absen_masuk.nullable' => 'keterangan absen masuk tidak boleh kosong!',
            'status_absen_masuk' => [
                'in' => 'status absen masuk yang dipilih tidak valid!',
            ],
            'keterlambatan_absen_masuk.date_format' => 'Format keterlambatan absen masuk tidak sama dengan format H:i:s!',
            'absen_pulang' => [
                'date_format' => 'Format absen pulang tidak sama dengan format H:i:s!',
            ],
            'keterangan_absen_pulang.nullable' => 'keterangan absen pulang tidak boleh kosong!',
            'status_absen_pulang' => [
                'in' => 'status absen pulang yang dipilih tidak valid!',
            ],
            'keterlambatan_absen_pulang.date_format' => 'Format keterlambatan absen pulang tidak sama dengan format H:i:s!',
        ];
    }
}

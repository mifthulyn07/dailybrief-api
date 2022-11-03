<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'email|unique:users,email',
            'no_telp' => 'numeric|unique:users,no_telp',
            'jns_kelamin' => 'in:Laki-laki,Perempuan',
            'mulai_kerja' => 'date',
        ];
    }
    public function messages()
    {
        return [
            'email' => [
                'email' => 'Email harus berupa alamat email yang valid',
                'unique' => 'Email sudah ada, gunakan email yang lain!',
            ],
            'no_telp' => [
                'numeric' => 'Nomor telepon harus berupa nomor!',
                'unique' => 'Nomor telepon sudah ada, gunakan Nomor telepon yang lain!',
            ],
            'jns_kelamin.in' => 'Jenis kelamin yang dipilih tidak valid!',
            'mulai_kerja.date' => 'Data yang di berikan tidak valid!',
        ];
    }
}

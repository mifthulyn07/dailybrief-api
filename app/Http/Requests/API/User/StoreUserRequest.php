<?php

namespace App\Http\Requests\API\User;

use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'no_telp' => 'numeric|unique:users,no_telp',
            'jns_kelamin' => 'in:Laki-laki,Perempuan',
            'mulai_kerja' => 'date',
            'role' => 'required|in:super-admin,staff',
        ];
    }
    public function messages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong!',
            'role' => [
                'required' => 'role tidak boleh kosong!',
                'in' => 'Role yang dipilih tidak valid!',
            ],
            'email' => [
                'required' => 'Email tidak boleh kosong!',
                'email' => 'Email harus berupa alamat email yang valid',
                'unique' => 'Email sudah ada, gunakan email yang lain!',
            ],
            'password.required' => 'Password tidak boleh kosong!',
            'confirm_password' => [
                'required' => 'konfirmasi Password tidak boleh kosong!',
                'same' => 'Password dan konfirmasi Password harus sama!',
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

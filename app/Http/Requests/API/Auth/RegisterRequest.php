<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            // 'no_telp' => 'required',
            // 'jns_kelamin' => 'required',
            // 'alamat' => 'required',
            // 'mulai_kerja' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
            'Confirm_password.required' => 'konfirmasi Password tidak boleh kosong!',
        ];
    }
}

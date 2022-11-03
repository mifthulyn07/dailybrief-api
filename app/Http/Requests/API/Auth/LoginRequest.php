<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email' => [
                'required' => 'Email tidak boleh kosong!',
                'email' => 'Email harus berupa alamat email yang valid',
            ],
            'password.required' => 'Password tidak boleh kosong!',
        ];
    }
}

<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($request)
    {
        $user = '';
        $getEmail = User::where('email', $request['email'])->first();
        // $getEmail = Auth::user()->email;
        if ( !$getEmail ) throw ValidationException::withMessages([
            'email' => ['Email tidak terdaftar!'],
        ]); 
        $user = $getEmail;           
        if ( !auth()->attempt( [ 'email' => $user->email, 'password' => $request['password'] ] ) ) {
            throw ValidationException::withMessages([
                'password' => ['Pastikan anda mengetik email dan password dengan benar!'],
            ]); 
        }
        $user->token = $user->createToken('auth_token')->plainTextToken;
        return $user;
    }

    public function profil()
    {
        $me = Auth::User();
        // $me = User::where('id', auth()->user()->id)->first();
        return $me;
    }

    public function register($request){
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request);
        $user->token =  $user->createToken('auth_token')->plainTextToken;
        return $user;
    }   

    public function logout($request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}
?>
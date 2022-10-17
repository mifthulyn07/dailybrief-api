<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request){
        try {
            $response = $this->service->login( $request->validated() );
            return $this->successResp('Anda Berhasil Login', new AuthResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function profil()
    {
        try {
            $response = $this->service->profil();
            return $this->successResp('Data berhasil ditemukan!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $response = $this->service->register( $request->validated() );
            return $this->successResp('Anda berhasil mendatar!', new AuthResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function logout(Request $request)
    {
        try {
            $response = $this->service->logout( $request );
            return $this->successResp('Anda berhasil log out!');
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
}

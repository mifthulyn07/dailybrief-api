<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\API\User\StoreUserRequest;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $response = $this->service->index($request);
            return $this->successResp('Berhasil mendapatkan data!', new UserCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $response = $this->service->store($request->all());
            return $this->successResp('Berhasil membuat user!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function show($id)
    {
        try {
            $response = $this->service->show($id);
            return $this->successResp('Berhasil mendapatkan data!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->service->update($request->all(), $id);
            return $this->successResp('Berhasil update user!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->service->destroy($id);
            return $this->successResp('Berhasil menghapus user!', $response);
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
}

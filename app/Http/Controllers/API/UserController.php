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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index( Request $request)
    {
        try {
            $response = $this->service->index($request);
            return $this->successResp('Berhasil mendapatkan list!', new UserCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $response = $this->service->store( $request->validated() );
            return $this->successResp('Berhasil membuat user!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $response = $this->service->show($id);
            return $this->successResp('Berhasil mendapatkan user!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $response = $this->service->update($request->all(), $id);
            return $this->successResp('Berhasil mengubah user!', new UserResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = $this->service->destroy($id);
            return $this->successResp('Berhasil menghapus user!', $response);
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    // public function changePassword(Request $request, $id)
    // {
    //     try {
    //         $response = $this->service->changePassword($request, $id);
    //         return $this->successResp('Berhasil menghapus user!', $response);
    //     } catch (ValidationException $th) {
    //         return $this->errorResp($th->errors());
    //     }
    // }
}

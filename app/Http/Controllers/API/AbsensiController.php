<?php

namespace App\Http\Controllers\API;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Services\AbsensiService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Absensi\AbsensiResource;
use App\Http\Resources\Absensi\AbsensiCollection;
use App\Http\Requests\API\Absensi\AbsenMasukRequest;
use App\Http\Requests\API\Absensi\AbsenPulangRequest;

class AbsensiController extends Controller
{
    protected $service;

    public function __construct(AbsensiService $service)
    {
        $this->service = $service;
    }
    
    public function absenMasuk(AbsenMasukRequest $request){
        try {
            $response = $this->service->absenMasuk( $request );
            return $this->successResp('Absensi berhasil!', new AbsensiResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function absenPulang(AbsenPulangRequest $request, $id){
        try {
            $response = $this->service->absenPulang( $request, $id );
            return $this->successResp('Absensi berhasil!', new AbsensiResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
    
    public function index(Request $request)
    {
        try {
            $response = $this->service->index($request);
            return $this->successResp('Berhasil mendapatkan Data!', new AbsensiCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function historyAbsen(Request $request)
    {
        try {
            $response = $this->service->historyAbsen($request);
            return $this->successResp('Berhasil mendapatkan Data!', new AbsensiCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

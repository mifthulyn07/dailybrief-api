<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ManagementReportService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\API\ManagementReport\StoreAbsensiRequest;
use App\Http\Requests\API\ManagementReport\UpdateAbsensiRequest;
use App\Http\Resources\ManagementReport\ManagementReportResource;
use App\Http\Resources\ManagementReport\ManagementReportCollection;

class ManagementReportController extends Controller
{
    protected $service;

    public function __construct(ManagementReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $response = $this->service->index($request);
            return $this->successResp('Berhasil mendapatkan data!', new ManagementReportCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function store(StoreAbsensiRequest $request)
    {
        try {
            $response = $this->service->store($request->all());
            return $this->successResp('Berhasil membuat absensi!', new ManagementReportResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function show($id)
    {
        try {
            $response = $this->service->show($id);
            return $this->successResp('Detail data', new ManagementReportResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function update(UpdateAbsensiRequest $request, $id)
    {
        try {
            $response = $this->service->update($request->all(), $id);
            return $this->successResp('Berhasil update absensi!', new ManagementReportResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->service->destroy($id);
            return $this->successResp('Berhasil menghapus absensi!', $response);
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
}

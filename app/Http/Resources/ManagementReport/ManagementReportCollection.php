<?php

namespace App\Http\Resources\ManagementReport;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ManagementReport\ManagementReportResource;

class ManagementReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'list' => ManagementReportResource::collection($this->collection),
            'terhitung' => [
                'absen_masuk' => [
                    'hadir' => $this->hadir_masuk,
                    'absen' => $this->absen_masuk,
                ],
                'absen_pulang' => [
                    'hadir' => $this->hadir_pulang,
                    'absen' => $this->absen_pulang,
                ],
            ],
            'meta' => [
                "total" => $this->total(), 
                "per_page" => $this->perPage(),
                "count_items" => $this->count(),
                "current_page" => $this->currentPage(),
                "last_page" => $this->lastPage(),
                "from" => $this->firstItem(),
                "to" => $this->lastItem(),
            ],
        ];
    }
}

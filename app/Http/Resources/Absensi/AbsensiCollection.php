<?php

namespace App\Http\Resources\Absensi;

use App\Models\Absensi;
use App\Http\Resources\Absensi\AbsensiResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AbsensiCollection extends ResourceCollection
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
            'list' => AbsensiResource::collection($this->collection),
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

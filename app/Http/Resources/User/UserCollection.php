<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'list' => UserResource::collection($this->collection),
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

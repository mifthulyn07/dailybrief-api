<?php

namespace App\Http\Resources\Absensi;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenPulangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tanggal' => $this->tanggal,
            'absen_pulang' => $this->absen_pulang,
            'keterangan_absen_pulang' => $this->keterangan_absen_pulang,
            'status_absen_pulang' => $this->status_absen_pulang,
            'keterlambatan_absen_pulang' => $this->keterlambatan_absen_pulang,
        ];
    }
}

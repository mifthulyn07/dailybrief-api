<?php

namespace App\Http\Resources\Absensi;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiResource extends JsonResource
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
            'absen_masuk' => $this->absen_masuk,
            'keterangan_absen_masuk' => $this->keterangan_absen_masuk,
            'status_absen_masuk' => $this->status_absen_masuk,
            'keterlambatan_absen_masuk' => $this->keterlambatan_absen_masuk,
            'absen_pulang' => $this->absen_pulang,
            'keterangan_absen_pulang' => $this->keterangan_absen_pulang,
            'status_absen_pulang' => $this->status_absen_pulang,
            'keterlambatan_absen_pulang' => $this->keterlambatan_absen_pulang,
        ];
    }
}

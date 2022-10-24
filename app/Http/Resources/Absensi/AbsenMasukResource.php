<?php

namespace App\Http\Resources\Absensi;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenMasukResource extends JsonResource
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
        ];;
    }
}

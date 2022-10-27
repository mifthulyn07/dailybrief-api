<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Absensi;

class AbsensiObserver
{
    /**
     * Handle the Absensi "created" event.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return void
     */
    public function creating(Absensi $absensi)
    {
        
    }

    /**
     * Handle the Absensi "updated" event.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return void
     */
    public function updated(Absensi $absensi)
    {
        //
    }

    /**
     * Handle the Absensi "deleted" event.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return void
     */
    public function deleted(Absensi $absensi)
    {
        //
    }

    /**
     * Handle the Absensi "restored" event.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return void
     */
    public function restored(Absensi $absensi)
    {
        //
    }

    /**
     * Handle the Absensi "force deleted" event.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return void
     */
    public function forceDeleted(Absensi $absensi)
    {
        //
    }
}

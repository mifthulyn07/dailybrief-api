<?php 
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class AbsensiService
{
    public function index($request){

        $me = Auth::user()->id;
        $query = Absensi::query()->where('user_id', $me);

        if($tanggal = $request->input('tanggal')){
            $query->whereDate('tanggal', 'like', $tanggal.'%');
        }

        if($status_absen_masuk = $request->input('status_absen_masuk')){
            $query->where('status_absen_masuk', 'like', $status_absen_masuk.'%');
        }

        if($status_absen_pulang = $request->input('status_absen_pulang')){
            $query->where('status_absen_pulang', 'like', $status_absen_pulang.'%');
        }

        if($request->has('order') && $request->order && $request->has('sort') && $request->sort){
            $query->orderBy($request->order, $request->sort);
        }

        if ($request->has('limit')) {
                $list = $query->with(['user'])->paginate( $request['limit'] );
            } else {
                $list = $query->with(['user'])->paginate(10);
        }

        return $list;
    }

    public function historyAbsen($request)
    {
        $me = Auth::user()->id;
        $query = Absensi::query()->where('user_id', $me);

        if($request->has('fromDate') && $request->fromDate && $request->has('toDate') && $request->toDate){
            $query->whereBetween('tanggal',[date($request->fromDate), date($request->toDate)]);
        }

        if($status_absen_masuk = $request->input('status_absen_masuk')){
            $query->where('status_absen_masuk', 'like', $status_absen_masuk.'%');
        }

        if($status_absen_pulang = $request->input('status_absen_pulang')){
            $query->where('status_absen_pulang', 'like', $status_absen_pulang.'%');
        }

        if($request->has('order') && $request->order && $request->has('sort') && $request->sort){
            $query->orderBy($request->order, $request->sort);
        }

        // menghitung absen & hadir 
        $query1 = $query->get();
        $hadir_masuk = $query1->where('status_absen_masuk', 'Hadir')->count();
        $absen_masuk = $query1->where('status_absen_masuk', 'Absen')->count();
        $hadir_pulang = $query1->where('status_absen_pulang', 'Hadir')->count();
        $absen_pulang = $query1->where('status_absen_pulang', 'Absen')->count();

        if ($request->has('limit')) {
            $list = $query->with(['user'])->paginate($request['limit']);
        } else {
            $list = $query->with(['user'])->paginate(10);
        }

        $list->hadir_masuk = $hadir_masuk;
        $list->absen_masuk = $absen_masuk;
        $list->hadir_pulang = $hadir_pulang;
        $list->absen_pulang = $absen_pulang;

        return $list;
    }

    public function absenMasuk($request)
    {
        $absensi['user_id'] = Auth::user()->id;
        $absensi['tanggal'] = date('Y/m/d');
        $absensi['absen_masuk'] = date('H:i:s');

        if( date('l') == 'Saturday' || date('l') == 'Sunday' )
        {
            throw ValidationException::withMessages([
                'absensi' => ['Hari libur tidak dapat absensi!'],
            ]);
        }
        elseif( Absensi::where('user_id', $absensi['user_id'])->where('tanggal', $absensi['tanggal'])->first() )
        {
            throw ValidationException::withMessages([
                'absensi' => ['Anda sudah melakukan absensi!.'],
            ]);
        }
        elseif(strtotime($absensi['absen_masuk']) < strtotime(config('absensi.jam_masuk'). ' -1 hours'))
        {
            throw ValidationException::withMessages([
                'absensi' => ['absensi dilakukan (7.30)-(8.30)!'],
            ]);
        }
        else
        {
            $absensi['keterangan_absen_masuk'] = $request->keterangan_absen_masuk;

            // absen_masuk >= (jam masuk - 1jam) && absen_masuk <= jam_masuk
            if(strtotime($absensi['absen_masuk']) >= strtotime(config('absensi.jam_masuk') . ' -1 hours') && strtotime($absensi['absen_masuk']) <= strtotime(config('absensi.jam_masuk'))){
                $absensi['status_absen_masuk'] = 'Hadir';
            // absen_masuk > (jam masuk)  
            }elseif(strtotime($absensi['absen_masuk']) > strtotime(config('absensi.jam_masuk'))){
                $absensi['status_absen_masuk'] = 'Absen';

                // menghitung ketrlambatan
                $jam_masuk = Carbon::parse('08:30:00');
                $absen_masuk = Carbon::parse($absensi['absen_masuk']);
                $absensi['keterlambatan_absen_masuk'] = $jam_masuk->diff($absen_masuk)->format('%H:%I:%S');
            }

            // create 
            $create = Absensi::create($absensi);

            return $create;
        }
    }

    public function absenPulang($request, $id)
    {
        $absensi['user_id'] = Auth::user()->id;
        $absensi['tanggal'] = date('Y/m/d');
        $absensi['absen_pulang'] = date('H:i:s');

        $update = Absensi::where('id', $id)->first();
        if ( !$update ) 
        {
            throw ValidationException::withMessages([
                'absensi' => ['Anda belum melakukan absensi masuk!.'],
            ]);
        }
        elseif ( !Absensi::where('user_id', $absensi['user_id'])->where('tanggal', $absensi['tanggal'])->first()) 
        {
            throw ValidationException::withMessages([
                'absensi' => ['tidak dapat absen pulang, tanggal & user berbeda!.'],
            ]);
        }
        elseif ( !Absensi::where('absen_pulang', null)->first() ) 
        {
            throw ValidationException::withMessages([
                'absensi' => ['Anda sudah melakukan absensi!.'],
            ]);
        }
        elseif(strtotime($absensi['absen_pulang']) < strtotime(config('absensi.jam_pulang'). ' -1 hours'))
        {
            throw ValidationException::withMessages([
                'absensi' => ['absensi dilakukan (16.15)-(17.15)!'],
            ]);
        }
        else{
            $absensi['keterangan_absen_pulang'] = $request->keterangan_absen_pulang;

            // absen_pulang >= (jam pulang-1) && absen_pulang <= jam_pulang
            if(strtotime($absensi['absen_pulang']) >= strtotime(config('absensi.jam_pulang') . ' -1 hours') && strtotime($absensi['absen_pulang']) <= strtotime(config('absensi.jam_pulang'))){
                $absensi['status_absen_pulang'] = 'Hadir';
            // absen_pulang > jam pulang 
            }elseif(strtotime($absensi['absen_pulang']) > strtotime(config('absensi.jam_pulang')) ){
                $absensi['status_absen_pulang'] = 'Absen';

                // menghitung keterlambatan
                $jam_pulang = Carbon::parse('16:15:00');
                $absen_pulang = Carbon::parse($absensi['absen_pulang']);
                $absensi['keterlambatan_absen_pulang'] = $jam_pulang->diff($absen_pulang)->format('%H:%I:%S');
            }elseif(strtotime($absensi['absen_pulang']) < strtotime(config('absensi.jam_pulang')) ){
                $absensi['status_absen_pulang'] = null;
            }
            
            // update 
            $update->update($absensi);

            return $update;
        }
    }
}
?>
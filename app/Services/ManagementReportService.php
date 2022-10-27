<?php 
namespace App\Services;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class ManagementReportService
{
    public function index($request)
    {
        $query = Absensi::query();

        if($tanggal = $request->input('tanggal')){
            $query->whereDate('tanggal', 'like', $tanggal.'%');
        }

        if($request->has('fromDate') && $request->fromDate && $request->has('toDate') && $request->toDate){
            $query->whereBetween('tanggal',[date($request->fromDate), date($request->toDate)]);
        }

        if($nama_idUser = $request->input('nama_idUser')){
            $query->where('id', 'like', $nama_idUser.'%')
            ->orWhere(function($query) use ($nama_idUser){
                $query->whereHas('user', function (Builder $query) use ($nama_idUser) {
                    $query->where('nama', 'like', $nama_idUser.'%');
                });
            });
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

    public function store($request)
    {
        $absensi['user_id'] = $request->user_id;
        $absensi['tanggal'] = $request->tanggal;
        $absensi['absen_masuk'] = $request->absen_masuk;
        $absensi['absen_pulang'] = $request->absen_pulang;
        $absensi['keterangan_absen_masuk'] = $request->keterangan_absen_masuk;
        $absensi['keterangan_absen_pulang'] = $request->keterangan_absen_pulang;

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
        }

        // create 
        $absensi = Absensi::create($absensi);

        return $absensi;
    }   

    public function show($id){
        $show = Absensi::where('id', $id)->first();
        if ( !$show ) throw ValidationException::withMessages([
            'data' => ['Data not found.'],
        ]); 
        return $show;
    }

    public function update($request, $id)
    {  
        $update = Absensi::where('id', $id)->first();
        if ( !$update ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!'],
        ]); 

        $absensi['user_id'] = $request->user_id;
        $absensi['tanggal'] = $request->tanggal;
        $absensi['absen_masuk'] = $request->absen_masuk;
        $absensi['absen_pulang'] = $request->absen_pulang;
        $absensi['keterangan_absen_masuk'] = $request->keterangan_absen_masuk;
        $absensi['keterangan_absen_pulang'] = $request->keterangan_absen_pulang;

        if ( $absensi['absen_masuk'] == null || $absensi['absen_masuk'] == null ){
            throw ValidationException::withMessages([
                'data' => ['Absen masuk dan pulang tidak boleh kosong!'],
            ]);
        }  

        if($absensi['absen_masuk'] < config('absensi.jam_masuk')){
            $absensi['status_absen_masuk'] = null;
            $absensi['keterlambatan_absen_masuk'] = null;
        }
        
        if($absensi['absen_pulang'] < config('absensi.jam_pulang')){
            $absensi['status_absen_pulang'] = null;
            $absensi['keterlambatan_absen_pulang'] = null;
        }

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
        }
        
        // update 
        $update->update($absensi);

        return $update;
    }

    public function destroy($id)
    {
        $destroy = Absensi::where('id', $id)->first();
        if ( !$destroy ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!'],
        ]); 
        $destroy->destroy($id);
        return $destroy;
    }   
}   
?>
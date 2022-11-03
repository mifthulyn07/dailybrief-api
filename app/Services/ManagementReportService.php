<?php 
namespace App\Services;

use Carbon\Carbon;
use App\Models\Absensi;
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
        $create = Absensi::create($request);
        return $create;
    }   

    public function show($id){
        $show = Absensi::where('id', $id)->first();
        if ( !$show ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!.'],
        ]); 
        return $show;
    }

    public function update($request, $id)
    {  
        $update = Absensi::where('id', $id)->first();
        if ( !$update ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!'],
        ]); 
        $update->update($request);
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
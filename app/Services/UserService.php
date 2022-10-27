<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function index($request)
    {
        $query = User::query();

        if($search = $request->input('search')){
            $query->whereDate('mulai_kerja', 'like', $search.'%')
                ->orWhere('id', 'like', $search.'%')
                ->orWhere('nama', 'like', $search.'%')
                ->orWhere('email', 'like',$search.'%')
                ->orWhere('jns_kelamin', 'like', $search.'%')
                ->orWhere('no_telp', 'like', $search.'%')
                ->orWhere('alamat', 'like', $search.'%');
        }

        if($request->has('order') && $request->order && $request->has('sort') && $request->sort){
            $query->orderBy($request->order, $request->sort);
        }

        if ($request->has('limit')) {
                $list = $query->paginate( $request['limit'] );
            } else {
                $list = $query->paginate(10);
        }

        return $list;
    }

    public function show($id){
        $show = User::where('id', $id)->first();
        if ( !$show ) throw ValidationException::withMessages([
            'data' => ['Data not found.'],
        ]); 
        return $show;
    }

    public function store($request)
    {
        $request['password'] = bcrypt($request['password']);
        $store = User::create($request);
        return $store;
    }   

    public function update($request, $id)
    {  
        $update = User::where('id', $id)->first();
        if ( !$update ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!'],
        ]); 
        $update->update($request);
        return $update;
    }

    public function destroy($id)
    {
        $destroy = User::where('id', $id)->first();
        if ( !$destroy ) throw ValidationException::withMessages([
            'data' => ['Data tidak ditemukan!'],
        ]); 
        $destroy->destroy($id);
        return $destroy;
    }   
}   
?>
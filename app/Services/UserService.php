<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function index($request)
    {
        $query = User::query();

        if($search = $request->input('search')){
            $query->whereDate('mulai_kerja', 'like', $search.'%')
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
            'data' => ['Data not found.'],
        ]); 
        $update->update($request);
        return $update;
    }

    public function destroy($id)
    {
        $destroy = User::where('id', $id)->first();
        if ( !$destroy ) throw ValidationException::withMessages([
            'data' => ['Data not found.'],
        ]); 
        $destroy->destroy($id);
        return $destroy;
    }   

    public function show($id)
    {
        $show = User::where('id', $id)->first();
        if ( !$show ) throw ValidationException::withMessages([
            'data' => ['Data not found.'],
        ]); 
        return $show;
    }

    // public function changePassword($request, $id)
    // {  
    //     $user = User::where('id', $id)->first();
    //     $user->password = Hash::make($request);
    //     if ( !$user ) throw ValidationException::withMessages([
    //         'data' => ['Data not found.'],
    //     ]); 
    //     $user->update($request);
    //     return $update;
    // }
}   
?>
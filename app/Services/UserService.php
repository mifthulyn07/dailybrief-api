<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function index()
    {
        $list = User::paginate(10);
        return $list;
    }

    public function store($request){
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request);
        return $user;
    }   

    public function update($request, $user)
    {
        $user->nama = $request['nama'];
        $user->jns_kelamin = $request['jns_kelamin'];
        $user->no_telp = $request['no_telp']; 
        $user->alamat = $request['alamat']; 
        $user->mulai_kerja = $request['mulai_kerja'];
        $user->email = $request['email']; 
        $user->password = $request['password'];  
        $request['password'] = bcrypt($request['password']);
        $user->save();

        return $user;
    }

    public function destroy($user){
        $user = $user->delete();
        return $user;
    }   
}
?>
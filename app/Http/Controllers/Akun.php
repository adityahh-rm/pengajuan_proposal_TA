<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roles;

class Akun extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function users(){
        $user = User::with(['roles'])->get();

        $roles = Roles::all();
        return view('kelolaUser', ['user'=>$user], compact('roles'));
    }
    
    #Kelola Akun      
        public function getDataUser($id){
            $user = User::find($id); 
            // $decrypted = Crypt::decryptString($user->password);
    
            return response()->json($user);
        }
    
        public function ubahUser(Request $req){
            $user = User::find($req->get('id')); //Menyesuaikan dengan id yang dikirim
    
            $user->password = bcrypt($req->get('password'));
    
            $user->save();
    
            $notification = array (
                'message' => 'Data User Berhasil Diubah',
                'alert-type' => 'success'
            );
    
            return redirect()->route('prodi.kelolaUser')->with($notification);
        }
    
        public function hapusUser(Request $req)
        {
            $user = User::find($req->get('id'));
    
            $user->delete();
    
            $notification = array(
                'message' => 'Data User Berhasil Dihapus',
                'alert-type' => 'success'
            );
    
            return redirect()->route('prodi.kelolaUser')->with($notification);
        } 
}

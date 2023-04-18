<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\User;

class kelolaMahasiswa extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function mahasiswa(){
        $user = Auth::user();
        $mahasiswa = Mahasiswa::all();
        return view('kelolaMahasiswa', compact('user', 'mahasiswa'));
    }

    public function tambahMahasiswa(Request $req){
        $mahasiswa = new Mahasiswa;

        $mahasiswa->npm = $req->get('npm');
        $mahasiswa->nama = $req->get('nama');
        $mahasiswa->email = $req->get('email');
        $mahasiswa->angkatan = $req->get('angkatan');

        $mahasiswa->save();

        $notification = array(
            'message' => 'Data Mahasiswa Berhasil Ditambah',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaMahasiswa')->with($notification); 
    }
    
    public function getDataMahasiswa($id){
        $mahasiswa = Mahasiswa::find($id); 

        return response()->json($mahasiswa);
    }

    public function ubahMahasiswa(Request $req){
        $mahasiswa = Mahasiswa::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $mahasiswa->npm = $req->get('npm');
        $mahasiswa->nama = $req->get('nama');
        $mahasiswa->email = $req->get('email');
        $mahasiswa->angkatan = $req->get('angkatan');

        $mahasiswa->save();

        $notification = array (
            'message' => 'Data Mahasiswa Berhasil Diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaMahasiswa')->with($notification);
    }

    public function hapusMahasiswa(Request $req)
    {
        $mahasiswa = Mahasiswa::find($req->get('id'));

        $mahasiswa->status = 0;

        $mahasiswa->save();

        $notification = array(
            'message' => 'Data Mahasiswa Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaMahasiswa')->with($notification);
    }  
    

    
}

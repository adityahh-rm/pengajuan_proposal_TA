<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Roles;

class Prodi extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function prodi(){
        $user = Auth::user();
        return view('home', compact('user'));
    }

    #Kelola Dosen
    public function dosen(){
        $user = Auth::user();
        $dosen = Dosen::all();
        return view('kelolaDosen', compact('user', 'dosen'));
    }

    public function tambahDosen(Request $req){
        $dosen = new Dosen; //objek dari Book

        //Field menjadi function -- data diambil dari inputan
        $dosen->nidn = $req->get('nidn');
        $dosen->nama = $req->get('nama');
        $dosen->keterangan = $req->get('keterangan');

        $dosen->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Dosen Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        //Hanya sekali proses saja
        return redirect()->route('prodi.kelolaDosen')->with($notification); 
    }
    
    //Process Ajax
    public function getDataDosen($id){
        $dosen = Dosen::find($id); 

        return response()->json($dosen);
    }

    public function ubahDosen(Request $req){
        $dosen = Dosen::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $dosen->nidn = $req->get('nidn');
        $dosen->nama = $req->get('nama');
        $dosen->keterangan = $req->get('keterangan');

        $dosen->save();

        $notification = array (
            'message' => 'Data Dosen Berhasil Diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaDosen')->with($notification);
    }

    public function hapusDosen(Request $req)
    {
        $dosen = Dosen::find($req->get('id'));
        // $dosen = Dosen::find($req->get('id'))->delete();

        $dosen->delete();

        $notification = array(
            'message' => 'Data Dosen Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaDosen')->with($notification);
    }   

    #Kelola Mahasiswa
    public function mahasiswa(){
        $user = Auth::user();
        $mahasiswa = Mahasiswa::all();
        return view('kelolaMahasiswa', compact('user', 'mahasiswa'));
    }

    public function tambahMahasiswa(Request $req){
        $mahasiswa = new Mahasiswa;

        //Field menjadi function -- data diambil dari inputan
        $mahasiswa->npm = $req->get('npm');
        $mahasiswa->nama = $req->get('nama');
        $mahasiswa->angkatan = $req->get('angkatan');

        $mahasiswa->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Mahasiswa Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        //Hanya sekali proses saja
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
        // $dosen = Dosen::find($req->get('id'))->delete();

        $mahasiswa->delete();

        $notification = array(
            'message' => 'Data Mahasiswa Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaMahasiswa')->with($notification);
    }  
    
    #Kelola Akun
    public function user(){
        $user = Auth::user();
        $users = User::all();
        $roles = Roles::all();
        return view('kelolaUser', compact('user', 'users', 'roles'));
    }

    public function tambahUser(Request $req){
        $users = new User;

        //Field menjadi function -- data diambil dari inputan
        $users->nama = $req->get('name');
        $users->username = $req->get('username');
        $users->password = $req->get('password');

        $users->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data User Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        //Hanya sekali proses saja
        return redirect()->route('prodi.kelolaUser')->with($notification); 
    }
    
    public function getDataUser($id){
        $users = User::find($id); 

        return response()->json($users);
    }

    public function ubahUser(Request $req){
        $user = User::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $user->name = $req->get('name');
        $user->username = $req->get('username');
        $user->password = $req->get('password');
        $user->roles_id = $req->get('roles_id');

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
        // $dosen = Dosen::find($req->get('id'))->delete();

        $user->delete();

        $notification = array(
            'message' => 'Data User Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaUser')->with($notification);
    } 
}

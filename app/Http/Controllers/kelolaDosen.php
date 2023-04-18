<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Proposal;

class kelolaDosen extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();

        $jumlahDosen = Dosen::all()->where("status",1)->count();
        $jumlahMahasiswa = Mahasiswa::all()->where("status", 1)->count();
        $totalProposalDisetujui = Proposal::all()->where("status", 3)->count();
        $statusProposal = Proposal::all()->where('user_id', $user->id);
        $jumlahUser = User::all()->count();

        return view('home', compact('user', 'jumlahDosen', 'jumlahMahasiswa', 'jumlahUser', 'totalProposalDisetujui', 'statusProposal'));
    }

    #Kelola Dosen
    public function dosen(){
        $user = Auth::user();
        $dosen = Dosen::all();
        return view('kelolaDosen', compact('user', 'dosen'));
    }

    public function tambahDosen(Request $req){
        $dosen = new Dosen;

        $dosen->nidn = $req->get('nidn');
        $dosen->nama = $req->get('nama');
        $dosen->email = $req->get('email');

        $dosen->save();

        $notification = array(
            'message' => 'Data Dosen Berhasil Ditambah',
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
        $dosen->email = $req->get('email');
        $dosen->nama = $req->get('nama');

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

        $dosen->status = 0;

        $dosen->save();

        $notification = array(
            'message' => 'Data Dosen Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('prodi.kelolaDosen')->with($notification);
    }   
}

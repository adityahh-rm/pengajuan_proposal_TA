<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Topik;
use App\Models\Dosen;

class Koordinator extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function topik(){
        $user = Auth::user();
        $topik = Topik::all();
        $dosen = Dosen::all();
        return view('kelolaTopik', compact('user', 'topik', 'dosen'));
    }

    #Kelola Topik
    public function tambahTopik(Request $req){
        $topik = new Topik;

        //Field menjadi function -- data diambil dari inputan
        $topik->judul_topik = $req->get('judul_topik');
        $topik->dosen_id = $req->get('dosen_id');

        $topik->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Topik Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        //Hanya sekali proses saja
        return redirect()->route('koordinator.kelolaTopik')->with($notification); 
    }
    
    public function getDataTopik($id){
        $topik = Topik::find($id); 

        return response()->json($topik);
    }

    public function ubahTopik(Request $req){
        $topik = Topik::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $topik->judul_topik = $req->get('judul_topik');
        $topik->dosen_id = $req->get('dosen_id');

        $topik->save();

        $notification = array (
            'message' => 'Data Topik Berhasil Diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('koordinator.kelolaTopik')->with($notification);
    }

    public function hapusTopik(Request $req)
    {
        $topik = Topik::find($req->get('id'));

        $topik->delete();

        $notification = array(
            'message' => 'Data Topik Berhasil Dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('koordinator.kelolaTopik')->with($notification);
    } 
}

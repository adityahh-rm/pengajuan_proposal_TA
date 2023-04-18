<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Topik;
use App\Models\Dosen;
use App\Models\Proposal;

class kelolaTopik extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();

        $totalTopik = Topik::all()->count();
        $statusProposal = Proposal::all()->where('user_id', $user->id);
        $totalProposal = Proposal::all()->count();
        $totalProposalRevisi = Proposal::all()->where("status", 1)->count();
        $totalProposalDiterima = Proposal::all()->where("status", 3)->count();

        return view('home', compact('user', 'totalTopik', 'totalProposal', 'totalProposalRevisi', 'totalProposalDiterima', 'statusProposal'));
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

        $topik->judul_topik = $req->get('judul_topik');
        $topik->dosen_id = $req->get('dosen_id');

        $topik->save();

        $notification = array(
            'message' => 'Data Topik Berhasil Ditambah',
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

    public function pilihTopik(Request $req){
        $topik = Topik::find($req->get('id'));
        
        $topik->status = 1;

        $topik->save();

        $notification = array (
            'message' => 'Topik Berhasil Dipilih',
            'alert-type' => 'success'
        );

        return redirect()->route('mahasiswa.kelolaTopik')->with($notification);
    }
}

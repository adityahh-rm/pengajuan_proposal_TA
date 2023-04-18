<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Mahasiswa;

class Proposal extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function pengajuanProposal()
    {
        $user = Auth::user();
        $proposal = Proposal::all();
        return view('pengajuan', compact('user', 'proposal'));
    }

    public function tambahPengajuan(Request $req){
        $proposal = new Proposal;
        $user = Auth::user();

        //Field menjadi function -- data diambil dari inputan
        $proposal->judul_proposal = $req->get('judul');
        $proposal->users_id = $req->get('users_id');

        if($req->hasFile('fileKP')){
            $extension = $req->file('fileKP')->extension();

            $berkaskp = $user->name.'_KP_'.time().'.'.$extension;

            $req->file('fileKP')->storeAs( 
                'public/fileKP', $berkaskp
            ); 

            $proposal->berkas_kp = $berkaskp;
        }

        if($req->hasFile('fileProposal')){
            $extension = $req->file('fileProposal')->extension();

            $filename = $user->name.'_proposal_'.time().'.'.$extension;

            $req->file('fileProposal')->storeAs( 
                'public/fileproposal', $filename
            ); 

            $proposal->berkas = $filename;
        }

        $proposal->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Pengajuan Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        //Hanya sekali proses saja
        return redirect()->route('mahasiswa.pengajuan')->with($notification); 
    }
    
    public function getDataPengajuan($id){
        $proposal = Proposal::find($id); 

        return response()->json($proposal);
    }

    public function revisiPengajuan(Request $req){
        $proposal = Proposal::find($req->get('id')); //Menyesuaikan dengan id yang dikirim
        $user = Auth::user();

        $req->validate([
            'fileProposal' => 'mimes:pdf'
        ]);

        if($req->hasFile('fileProposal')){
            $extension = $req->file('fileProposal')->extension();

            $filename = $user->name.'_proposal_'.time().'.'.$extension;

            $req->file('fileProposal')->storeAs(
                'public/fileproposal',$filename
            );

            Storage::delete('public/file_proposal/'.$req->get('old-fileProposal'));
            $proposal->file = $filename;
        }

        $proposal->save();

        $notification = array (
            'message' => 'Proposal Revisi Berhasil Dikirim',
            'alert-type' => 'success'
        );

        return redirect()->route('mahasiswa.pengajuan')->with($notification);
    }

}

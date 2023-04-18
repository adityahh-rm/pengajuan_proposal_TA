<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Models\Proposal;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class Pengajuan extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        $statusProposal = Proposal::all()->where('user_id', $user->id);
        $statusProposalMenungguDosen = Proposal::all()->where('dosen_id', $user->id)->where('status', 2)->count();
        $statusProposalDisetujuiDosen = Proposal::all()->where('dosen_id', $user->id)->where('status', 3)->count();
        $proposal = Proposal::all();

        return view('home', compact('user', 'proposal', 'statusProposal', 'statusProposalDisetujuiDosen', 'statusProposalMenungguDosen'));
    }

    public function pengajuanProposal()
    {
        $user = Auth::user();
        $dosens = Dosen::all();

        $dosen = new Dosen;

        $proposal = Proposal::all();
        $proposalByUser = Proposal::all()->where('user_id', $user->id);
        $proposalByDosen = Proposal::all()->where('dosen_id', $user->id);

        return view('pengajuan', compact('user', 'proposal', 'dosens', 'proposalByUser', 'proposalByDosen'));
    }

    public function tambahPengajuan(Request $req){
        $proposal = new Proposal;

        $user = Auth::user();

        $req->validate([
            'berkas_kp' => 'mimes:pdf',
            'berkas' => 'mimes:pdf'
        ]);

        $proposal->judul = $req->get('judul');
        $proposal->user_id = $user->id;

        if($req->hasFile('berkas_kp')){
            $extension = $req->file('berkas_kp')->extension();

            $berkaskp = $user->name.'_KP_'.time().'.'.$extension;

            $req->file('berkas_kp')->storeAs( 
                'public/fileKP', $berkaskp
            ); 

            $proposal->berkas_kp = $berkaskp;
        }

        if($req->hasFile('proposal')){
            $extension = $req->file('proposal')->extension();

            $filename = $user->name.'_proposal_'.time().'.'.$extension;

            $req->file('proposal')->storeAs( 
                'public/fileproposal', $filename
            ); 

            $proposal->berkas = $filename;
        }

        $proposal->save();

        $notification = array(
            'message' => 'Data Pengajuan Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('mahasiswa.pengajuan')->with($notification); 
    }

    public function revisiPengajuan(Request $req){
        $proposal = Proposal::find($req->get('id'));
        
        $user = Auth::user();

        $req->validate([
            'berkas' => 'mimes:pdf'
        ]);

        if($req->hasFile('berkas')){
            $extension = $req->file('berkas')->extension();

            $filename = $user->name.'_proposal_'.time().'.'.$extension;

            $req->file('berkas')->storeAs(
                'public/fileproposal',$filename
            );

            Storage::delete('public/fileproposal/'.$req->get('berkas'));
            
            $proposal->berkas = $filename;
        }

        $proposal->save();

        $notification = array (
            'message' => 'Proposal Revisi Berhasil Dikirim',
            'alert-type' => 'success'
        );

        return redirect()->route('mahasiswa.pengajuan')->with($notification);
    }

    public function lihatRevisi($id){
        $proposal = Proposal::find($id);

        return response()->json($proposal);
    }
    
    public function getDataPengajuan($id){
        $proposal = Proposal::find($id); 

        return response()->json($proposal);
    }

    public function revisiPengajuanKoordinator(Request $req){
        $proposal = Proposal::find($req->get('id-proposal-feedback'));
        $proposal->feedback = $req->get('feedback');
        $proposal->status = '1';

        $proposal->save();

        $notification = array(
            'message' => 'Revisi Proposal Telah Dikirim',
            'alert-type' => 'success'
        );
        return redirect()->route('koordinator.pengajuan')->with($notification);
    }

    public function terimaPengajuanKoordinator(Request $req){
        $proposal = Proposal::find($req->get('id'));

        $proposal->status = '2';

        $proposal->save();

        $notification = array(
            'message' => 'Proposal Telah Diterima',
            'alert-type' => 'success'
        );
        return redirect()->route('koordinator.pengajuan')->with($notification);
    }

    public function pilihDosenPembimbing(Request $req){
        $proposal = Proposal::find($req->get('id'));

        $dosen = Dosen::all();
        $proposal->dosen_id = $req->get('dosen_id');  

        $proposal->save();

        $notification = array (
            'message' => 'Dosen Pembimbing Berhasil Dipilih',
            'alert-type' => 'success'
        );

        return redirect()->route('koordinator.pengajuan')->with($notification);
    }

    public function validasiProposalPembimbing(Request $req){
        $proposal = Proposal::find($req->get('id-validasi-dosen'));
 
        $proposal->status = '3';  

        $proposal->save();

        $notification = array (
            'message' => 'Dosen Pembimbing Berhasil Dipilih',
            'alert-type' => 'success'
        );

        return redirect()->route('dosen.pengajuan')->with($notification);
    }

    public function tampilRevisi(Request $req){
        
    }

    public function downloadProposal($filename){
        $path = public_path('storage/fileproposal/'.$filename);

        return response()->download($path);
    }

}

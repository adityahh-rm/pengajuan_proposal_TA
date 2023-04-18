<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Proposal;
use App\Models\Topik;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $proposal = Proposal::all();
        $jumlahUser = User::all()->count();
        $totalTopik = Topik::all()->count();
        $totalProposal = Proposal::all()->count();
        $jumlahDosen = Dosen::all()->where("status",1)->count();
        $jumlahMahasiswa = Mahasiswa::all()->where("status", 1)->count();

        $statusProposal = Proposal::all()->where('user_id', $user->id);
        $totalProposalDisetujui = Proposal::all()->where("status", 3)->count();
        $statusProposalMenungguDosen = Proposal::all()->where('dosen_id', $user->id)->where('status', 2)->count();
        $statusProposalDisetujuiDosen = Proposal::all()->where('dosen_id', $user->id)->where('status', 3)->count();
        $totalProposalRevisi = Proposal::all()->where("status", 1)->count();
        $totalProposalDiterima = Proposal::all()->where("status", 3)->count();

        return view('home', 
            compact('user', 'proposal', 'totalTopik', 'totalProposal', 'jumlahUser' ,'jumlahDosen', 'jumlahMahasiswa', 'statusProposal', 'totalProposalDisetujui', 'statusProposalMenungguDosen' , 'statusProposalDisetujuiDosen', 'totalProposalRevisi', 'totalProposalDiterima')
        );
    }
}

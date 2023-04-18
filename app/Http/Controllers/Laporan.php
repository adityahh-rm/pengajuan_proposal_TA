<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Proposal;
use App\Models\Dosen;
use App\Models\mLaporan;

class Laporan extends Controller
{
    //

    public function lihatLaporan(){
        $user = Auth::user();

        $proposal = Proposal::all();

        return view('laporan', compact('user', 'proposal'));
    }

    // public function filterLaporan(){
    //     if (request()->start_date || request()->end_date) {
    //         $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
    //         $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            
    //         $data = App\Models\Proposal::whereBetween('updated_at', [$start_date,$end_date])->get();
    //     } else {
    //         $data = App\Models\Proposal::latest()->get();
    //     }
        
    //     return view('laporan', compact('data'));
    // }
}

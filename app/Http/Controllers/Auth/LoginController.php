<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array(
            'email' => $input['email'],
            'password' => $input['password']
        ))) 
        {
            if(auth()->user()->roles_id == 1){
                return redirect()->route('prodi.home');
            } else if(auth()->user()->roles_id == 2){
                return redirect()->route('koordinator.home');
            } else if(auth()->user()->roles_id == 3){
                return redirect()->route('dosen.home');
            } else if(auth()->user()->roles_id == 4){
                return redirect()->route('mahasiswa.home');
            }    
        }
        else {
            return redirect()->route('login')->with('Email Address and Password Are Wrong.');
        }  
        
        
    }
}

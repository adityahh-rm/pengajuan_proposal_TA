<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Prodi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->roles_id == 1){
            return $next($request);
        }

        return redirect('login')->with('error', 'Anda Tidak Memiliki Akses Sebagai Prodi');
    }
}

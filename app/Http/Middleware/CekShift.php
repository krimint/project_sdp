<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Shift;
use Illuminate\Http\Request;

class CekShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $cek = Shift::latest()->where('user_id',auth()->user()->id)
                    ->whereDate('waktu_awal',date('Y-m-d'))
                    ->first();
        if($request->getRequestUri() != '/cashawal'){

            if(is_null($cek)){
                return redirect()->intended('cashawal');
            }
        }

        return $next($request);


    }
}

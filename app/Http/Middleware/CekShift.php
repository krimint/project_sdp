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

        $cek = Shift::where('user_id',auth()->user()->id)
                    ->latest()
                    ->first();
        if($request->getRequestUri() != '/cashawal' && \Auth::user()->role == 'User'){
            if(!$cek || session()->get('shift') == 'N'){
                return redirect()->intended('cashawal');
            }
        }

        return $next($request);


    }
}

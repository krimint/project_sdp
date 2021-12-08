<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shift;

class AuthController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials['active'] = 1;
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            // cek ke data sblmnya shift
            $cek = Shift::where('user_id',auth()->user()->id)
                    ->latest()
                    ->first();
            if(Auth::user()->role == 'User' && $cek != null){
                session([
                    'shift' => 'N'
                ]);
                return redirect()->intended('cashawal');
            }
            /////
            return redirect()->intended('dashboard');
        }

        return back()->with('loginErr','Login gagal!');
    }

    public function logout(Request $request)
    {
        $cek = Shift::where('user_id',auth()->user()->id)
                    ->latest()
                    ->first();
        if(Auth::user()->role == 'User' && session()->get('shift') == 'Y'){
            return view('shift.cashakhir',compact('cek'));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');

    }
}

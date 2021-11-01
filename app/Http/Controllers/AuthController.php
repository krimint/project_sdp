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
            $cek = Shift::latest()->where('user_id',auth()->user()->id)
                    ->whereDate('waktu_awal',date('Y-m-d'))
                    ->first();
            if(is_null($cek)){
                return redirect()->intended('cashawal');
            }
            /////
            return redirect()->intended('dashboard');
        }

        return back()->with('loginErr','Login gagal!');
    }

    // public function tes(){
    //     $user = User::find(Auth::user()->id);
    //     return $user->shift;
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

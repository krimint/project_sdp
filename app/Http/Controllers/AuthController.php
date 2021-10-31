<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
           

            return redirect()->intended('dashboard');
        }

        return back()->with('loginErr','Login gagal!');
    }

    public function tes(){
        $user = User::find(Auth::user()->id);
        return $user->shift;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

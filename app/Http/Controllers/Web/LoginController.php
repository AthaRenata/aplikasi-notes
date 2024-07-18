<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone'=>'required',
            'password'=>'required'
        ]);

        if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                if (Auth::user()->role===1 && Auth::user()->is_active===1 ) {
                    return redirect()->intended('/users');
                }else{
                    return back()->with('loginError','Anda tidak memiliki hak akses untuk login');
                }

            }

        return back()->with('loginError','Login gagal');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

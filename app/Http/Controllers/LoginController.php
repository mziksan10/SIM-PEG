<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth/login/index', [
            'title' => 'Login'
        ]);

    }

    public function authenticate(Request $request){
        $cariData = DB::select("SELECT nama FROM pegawais where nip = '$request->username' ");
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if($request->username == 'admin'){
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Halo selamat datang');
            }
        }elseif($cariData == true){
            Session::put('nama', $cariData[0]->nama);
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Halo selamat datang');
            }
        }

        return back()->with('failed', 'Login gagal');
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login');
    }
}

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
        $cariData = DB::select("SELECT id, nama, foto FROM pegawais where nip = '$request->username' ");
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if($request->username == 'admin'){
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Halo selamat datang');
            }
        }elseif($cariData == true ){
            Session::put('pegawai_id', $cariData[0]->id);
            Session::put('nama', $cariData[0]->nama);
            Session::put('foto', $cariData[0]->foto);
            if(Auth::attempt($credentials)){
                if(Auth::user()->role == 'guest'){
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return back()->with('failed', 'Akun belum diaktivasi.');
                }
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

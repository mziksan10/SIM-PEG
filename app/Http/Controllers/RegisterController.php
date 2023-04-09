<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index(){
        return view('auth/register/index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request){
        $cariData = DB::select("SELECT * FROM pegawais where nip = '$request->username' ");
        if($cariData == false){
        return redirect('/register')->with('failed', 'Registrasi gagal! NIP tidak ditemukan.');
        }
        $validatedData = $request->validate([
            'username' => 'required|max:255|min:3|unique:users',
            'password' => 'required|max:255|min:5',
            'confirmPassword' => 'required|max:255|min:5|same:password',
        ]);
        $validatedData['pegawai_id'] = $cariData[0]->id;
        $validatedData['email'] = $cariData[0]->email;
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Hubungi admin untuk Aktivasi');

    }
}

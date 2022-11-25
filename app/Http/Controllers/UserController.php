<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/index', [
            'title' => 'User',
            'data_user' => User::paginate('5'),
            'role' => User::data_role()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cariData = DB::select("SELECT * FROM pegawais where nip = '$request->username' ");
        if($cariData == false){
        return redirect('/user')->with('failed', 'Data user gagal diinput!');
        }
        $validatedData = $request->validate([
            'username' => 'required|max:255|min:3|unique:users',
            'password' => 'required|max:255|min:5',
            'role' => 'required'
        ]);
        $validatedData['pegawai_id'] = $cariData[0]->id;
        $validatedData['email'] = $cariData[0]->email;
        $validatedData['role'] = $request->role;
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        return redirect('/user')->with('success', 'Data user berhasil diinput!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [];
        $validatedData = $request->validate($rules);
        if($request->username != $user->username && $request->password != $user->password){
            $rules['username'] = 'required|max:255|min:3|unique:users';
            $rules['email'] = 'required|unique:users|email';
        }
        $validatedData['role'] = $request->role;
        User::where('id', $user->id)->update($validatedData);
        return redirect('/user')->with('success', 'Data user berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/user')->with('success', 'Data user berhasil dihapus!');
    }
}

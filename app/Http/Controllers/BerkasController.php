<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|file|max:3072',
        ]);
        $validatedData['pegawai_id'] = $request->pegawai_id;
        if(request()->file('file')){ 
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');  
        }
        Berkas::create($validatedData);
        return redirect('/pegawai/' . $request->pegawai_id)->with('success', 'Data berkas berhasil diinput!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getBerkas = Berkas::select('*')->where('id', $id)->get();
        foreach($getBerkas as $berkas)
        if($berkas->file){
            Storage::delete($berkas->file);
        }
        Berkas::destroy($berkas->id);
        return Redirect::back()->with('success', 'Data berkas berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pegawai;
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
        return view ('pemberkasan/index',[
            'title' => 'Riwayat Pemberkasan',
            'data_berkas' => Berkas::latest()->get(),
            'jenisBerkas' => Berkas::jenisBerkas(),
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
        $pegawaiId = Pegawai::select('id')->where('nip', $request->nip)->get();
        $validatedData = $request->validate([
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|file|max:1024',
        ]);
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        if(request()->file('file')){ 
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');  
        }
        Berkas::create($validatedData);
        return redirect()->back()->with('success', 'Data berkas berhasil diinput!');
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
    public function update(Request $request, Berkas $berkas)
    {
        $rules = [
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'mimes:pdf|file|max:1024',
        ];
        $validatedData = $request->validate($rules);
        if(request()->file('file')){ 
            if($request->file_lama){
                Storage::delete($request->file_lama);
            }
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');  
        }
        Berkas::where('id', $berkas->id)->update($validatedData);
        return redirect('/riwayat-pemberkasan')->with('success', 'Data riwayat pemberkasan berhasil diubah!');
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

    public function index_()
    {
        return view ('pemberkasan/pegawai/index',[
            'title' => 'Pemberkasan',
            'data_berkas' => Berkas::where('pegawai_id', session()->get('pegawai_id'))->get(),
            'jenisBerkas' => Berkas::jenisBerkas(),
        ]);
    }

    public function store_(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|file|max:1024',
        ]);
        $validatedData['pegawai_id'] = $request->pegawai_id;
        if(request()->file('file')){ 
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');  
        }
        Berkas::create($validatedData);
        return redirect()->back()->with('success', 'Data berkas berhasil diinput!');
    }

    public function destroy_($id)
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

<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class RiwayatPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('riwayat-pendidikan/index', [
            'title' => 'Riwayat Pendidikan',
            'data_riwayatPendidikan' => RiwayatPendidikan::get(),
            'jenjang' => RiwayatPendidikan::jenjang(),
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
            'jenjang' => 'required',
            'jurusan' => 'nullable',
            'institusi' => 'required',
            'tahun_lulus' => 'required',
            'scan_ijazah' => 'required|mimes:pdf|max:1024',
        ]);
        if(request()->file('scan_ijazah')){ 
            $validatedData['scan_ijazah'] = request()->file('scan_ijazah')->store('berkas-pegawai');  
        }
        
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatPendidikan::create($validatedData);
        return back()->with('success', 'Data riwayat pendidikan berhasil diinput!');
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
        $rules = [
            'nip' => 'required',
            'jenjang' => 'required',
            'jurusan' => 'nullable',
            'institusi' => 'required',
            'tahun_lulus' => 'required',
        ];
        $validatedData = $request->validate($rules);
        RiwayatPendidikan::where('id', $riwayatJabatan->id)->update($validatedData);
        return redirect('/riwayat-pendidikan')->with('success', 'Data riwayat pendidikan berhasil diinput!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RiwayatPendidikan::destroy($id);
        return redirect('/riwayat-pendidikan')->with('success', 'Data riwayat pendididkan berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use App\Imports\RiwayatJabatansImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('riwayat-jabatan/index', [
            'title' => 'Riwayat Jabatan',
            'data_riwayatjabatan' => RiwayatJabatan::orderBy('tmt_bekerja', 'DESC')->get(),
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'status' => ['Kontrak', 'Tetap']
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
            'nip' => 'required',
            'bidang_id' => 'required',
            'jabatan_id' => 'required',
            'golongan_id' => 'required',
            'tmt_golongan' => 'required',
            'tmt_bekerja' => 'required',
            'scan_sk' => 'required|mimes:pdf|max:1024',
        ]);
        $getStatus = Golongan::where('id', $request->golongan_id)->pluck('status');
        if($getStatus[0] == "Tetap"){
            $selectNIP = Pegawai::select('nip')->where('status', '1')->latest('tanggal_masuk')->first();
            if($selectNIP == null){
                $createNIP = '130041' . date('dmy') . '1' . '001'; 
            }else{
                $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
            }
            $dataBaru = [];
            $dataBaru['nip'] = $createNIP;  
            $dataBaru['status'] = 1;
            Pegawai::where('id', $pegawaiId[0]->id)->update($dataBaru);
        }
        if(request()->file('scan_sk')){ 
            $validatedData['scan_sk'] = request()->file('scan_sk')->store('berkas-pegawai');  
        }
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatJabatan::create($validatedData);
        return redirect('/riwayat-jabatan')->with('success', 'Data riwayat jabatan berhasil diinput!');
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
    public function update(Request $request, RiwayatJabatan $riwayatJabatan)
    {
        $rules = [
            'bidang_id' => 'required',
            'jabatan_id' => 'required',
            'golongan_id' => 'required',
            'tmt_golongan' => 'required',
            'tmt_bekerja' => 'required',
            'scan_sk' => 'mimes:pdf|file|max:1024',
        ];
        $validatedData = $request->validate($rules);
        if(request()->file('scan_sk')){ 
            if($request->file_lama){
                Storage::delete($request->scan_sk_lama);
            }
            $validatedData['scan_sk'] = request()->file('scan_sk')->store('berkas-pegawai');  
        }
        RiwayatJabatan::where('id', $riwayatJabatan->id)->update($validatedData);
        return redirect('/riwayat-jabatan')->with('success', 'Data riwayat jabatan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiwayatJabatan $riwayatJabatan)
    {
        if($riwayatJabatan->scan_sk){
            Storage::delete($riwayatJabatan->scan_sk);
        }
        
        RiwayatJabatan::destroy($riwayatJabatan->id);
        return redirect('/riwayat-jabatan')->with('success', 'Data riwayat jabatan berhasil dihapus!');
    }
    public function import(Request $request) 
    {
        if(request()->file('file')){
            Excel::import(new RiwayatJabatansImport, request()->file('file'));
            return redirect('/riwayat-jabatan')->with('success', 'Data riwayat jabatan berhasil diimpor!');
        }
        
        return redirect('/riwayat-jabatan');
    }
}

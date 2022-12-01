<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use Illuminate\Http\Request;

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
            'data_riwayatjabatan' => RiwayatJabatan::latest()->filter(request(['search']))->paginate('5')->withQueryString(),
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
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
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
        ]);
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        $statusUpdate['status'] = 'Aktif';
        Pegawai::where('id', $pegawaiId[0]->id)->update($statusUpdate);
        RiwayatJabatan::create($validatedData);
        return redirect('/riwayat-jabatan')->with('success', 'Data pegawai cuti berhasil diinput!');
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
        //
    }
}

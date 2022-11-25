<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cuti/index', [
            'title'=> 'Data Cuti Pegawai',
            'data_cuti' => Cuti::orderBy('tanggal_cuti')->filter(request(['search']))->paginate('5')->withQueryString(),
            'data_pegawai' => Pegawai::all(),
            'jenis_cuti' => Cuti::data_jenis_cuti(),
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
            'jenis_cuti' => 'required',
            'tanggal_cuti' => 'required',
            'tanggal_masuk' => 'required',
        ]);
        foreach($pegawaiId as $item){
            $validatedData['pegawai_id'] = $item['id'];
        }
        Cuti::create($validatedData);
        return redirect('/cuti')->with('success', 'Data pegawai cuti berhasil diinput!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuti $cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuti $cuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuti $cuti)
    {
        //
    }

    public function pegawaiList(){
        $pegawai = Pegawai::select('nip', 'nama')->get();
        $data = [];

        foreach ($pegawai as $item){
            $data[] = $item['nip'];
        }

        return $data;
    }
}

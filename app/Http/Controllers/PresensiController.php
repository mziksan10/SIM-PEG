<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PresensiController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presensi $presensi)
    {
        //
    }

    public function index_()
    {
        $presensi = Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->first();
        return view('presensi/pegawai/index',[
            'title' => 'Presensi',
            'presensi' => $presensi,
            'data_presensi' => Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->get()
        ]);
    }

    public function absen_masuk(Request $request)
    {
        $jam_masuk = strtotime('07:45:00');
        $data['jam_masuk'] = date('H:i:s');
        $data['tanggal'] = date('Y-m-d');
        $data['pegawai_id'] = session()->get('pegawai_id');

        if (strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jam_masuk))) {
            $data['keterangan'] = 'Masuk';
        }else{
            return redirect()->back()->with('failed', 'Absen masuk gagal!');
        }

        Presensi::create($data);
        return redirect()->back()->with('success','Absen masuk berhasil!');
    }

    public function absen_pulang(Presensi $presensi)
    {
        $presensi = Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'));
        $jam_keluar = strtotime('17:00:00');
        $data['jam_keluar'] = date('H:i:s');

        if($presensi->whereKeterangan('Normal')->first()){
            return redirect()->back()->with('failed', 'Sesi telah berkahir!');
        }

        if (strtotime($data['jam_keluar']) >= strtotime(config('autran-presensi.jam_masuk'))) {
            $data['keterangan'] = 'Normal';
        }else{
            return redirect()->back()->with('failed', 'Absen pulang gagal!');
        }

        Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->update($data);
        return redirect()->back()->with('success', 'Absen pulang berhasil!');
    }
}

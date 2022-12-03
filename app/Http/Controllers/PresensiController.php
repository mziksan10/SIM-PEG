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
        $data['jam_masuk'] = date('H:i:s');
        $data['tanggal'] = date('Y-m-d');
        $data['pegawai_id'] = session()->get('pegawai_id');

        // Aturan Masuk Sesi ke- 1
        $jam_masuk_sesi1 = strtotime('07:45:00');
        $jms1_min = strtotime('07:30:00');
        $jms1_late1 = strtotime('08:00:00');
        $jms1_late2 = strtotime('08:15:00');
        $jms1_max = strtotime('08:20:00');

        // Aturan Masuk Sesi ke- 2
        $jam_masuk_sesi2 = strtotime('11:00:00');
        $jms2_min = strtotime('10:50:00');
        $jms2_late1 = strtotime('11:15:00');
        $jms2_late2 = strtotime('11:30:00');
        $jms2_max = strtotime('11:35:00');

        // Validasi Absen Masuk
        if(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms1_min)) && strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jam_masuk_sesi1)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jms1_late1))){
            $data['status'] = 'Sesi 1 - Normal';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms1_late1)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jms1_late2))){
            $data['status'] = 'Sesi 1 - Late 1';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms1_late2)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms1_max))){
            $data['status'] = 'Sesi 1 - Late 2';      
        }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', $jam_masuk_sesi2))){
            return redirect()->back()->with('failed','Sesi 1 telah berakhir!');
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms2_min)) && strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jam_masuk_sesi2)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jms2_late1))){
            $data['status'] = 'Sesi 2 - Normal';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms2_late1)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jms2_late2))){
            $data['status'] = 'Sesi 2 - Late 1';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms2_late2)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms2_max))){
            $data['status'] = 'Sesi 2 - Late 2';      
        }else{
            return redirect()->back()->with('failed','Sesi 2 telah berakhir!');
        }

        Presensi::create($data);
        return redirect()->back()->with('success','Absen masuk berhasil!');
    }

    public function absen_pulang(Presensi $presensi)
    {
        $presensi = Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->first();
        // Aturan Pulang Sesi ke- 1
        $jam_pulang_sesi1 = strtotime('17:00:00');
        
        // Aturan Pulang Sesi ke- 1
        $jam_pulang_sesi2 = strtotime('20:00:00');

        $data['jam_keluar'] = date('H:i:s');
        $diff = strtotime($data['jam_keluar']) - strtotime($presensi->jam_masuk);
        $jam = floor($diff / (60 * 60));
        $menit = $diff - $jam * (60 * 60);

        if($jam >= 9){
            $data['keterangan'] = 'Normal'; 
        }elseif($jam <= 8){
            return redirect()->back()->with('failed','Anda belum bisa absen pulang!');
        }
        
        if($presensi->keterangan == 'Normal'){
            return redirect()->back()->with('failed','Anda sudah absen pulang!');
        }

        Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->update($data);
        return redirect()->back()->with('success', 'Absen pulang berhasil!');
    }
}

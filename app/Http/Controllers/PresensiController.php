<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Exports\PresensisExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('presensi/index',[
                'title' => 'Presensi',
                'data_presensi' => Presensi::latest()->filter(request(['search']))->paginate('5')->withQueryString()
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

    public function export() 
    {
        return Excel::download(new PresensisExport, 'rekap-presensi-pegawai.xlsx');
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
        $jms1_min = strtotime('07:00:00');
        $jms1_late1 = strtotime('08:00:00');
        $jms1_late2 = strtotime('08:15:00');
        $jms1_max = strtotime('08:20:00');

        // Aturan Masuk Sesi ke- 2
        $jam_masuk_sesi2 = strtotime('11:00:00');
        $jms2_min = strtotime('10:15:00');
        $jms2_late1 = strtotime('11:15:00');
        $jms2_late2 = strtotime('11:30:00');
        $jms2_max = strtotime('11:35:00');

        // Validasi Absen Masuk
        if(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms1_min)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jam_masuk_sesi1))){
            $data['sesi'] = 'Sesi 1';
            $data['status'] = 'Normal';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jam_masuk_sesi1)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms1_late1))){
            $data['sesi'] = 'Sesi 1';
            $data['status'] = 'Normal';
        }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', $jms1_late1)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms1_late2))){
            $data['sesi'] = 'Sesi 1';
            $data['status'] = 'Late 1';
        }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', $jms1_late2)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms1_max))){
            $data['sesi'] = 'Sesi 1';
            $data['status'] = 'Late 2';      
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jms2_min)) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', $jam_masuk_sesi2))){
            $data['sesi'] = 'Sesi 2';
            $data['status'] = 'Normal';
        }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', $jam_masuk_sesi2)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms2_late1))){
            $data['sesi'] = 'Sesi 2';
            $data['status'] = 'Normal';
        }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', $jms2_late1)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms2_late2))){
            $data['sesi'] = 'Sesi 2';
            $data['status'] = 'Late 1';
        }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', $jms2_late2)) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', $jms2_max))){
            $data['sesi'] = 'Sesi 2';
            $data['status'] = 'Late 2';      
        }else{
            return redirect()->back()->with('failed','Sesi telah berakhir');
        }

        Presensi::create($data);
        return redirect()->back()->with('success','Absen masuk berhasil!');
    }

    public function absen_pulang(Presensi $presensi)
    {
        $presensi = Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->first();

        $data['jam_keluar'] = date('H:i:s');
        $diff = strtotime($data['jam_keluar']) - strtotime($presensi->jam_masuk);
        $jam = floor($diff / (60 * 60));
        $menit = $diff - $jam * (60 * 60);

        if($jam >= 10){
            $data['keterangan'] = 'Lembur ' . floor($jam - 9).' jam '.floor( $menit / 60 ). ' menit'; 
        }elseif($jam == 9){
            $data['keterangan'] = 'Normal';
        }elseif($jam <= 8){
            return redirect()->back()->with('failed','Anda belum bisa absen pulang!');
        }elseif($presensi->keterangan != null){
            return redirect()->back()->with('failed','Anda sudah absen pulang!');
        }

        Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->update($data);
        return redirect()->back()->with('success', 'Absen pulang berhasil!');
    }
}

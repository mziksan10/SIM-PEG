<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\AturanPresensi;
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
                'data_presensi' => Presensi::latest()->get(),
                'aturan_presensi' => AturanPresensi::get(),
        ]);
    }

    public function ubah_presensi(Request $request){
        $rules = [
            'jam_masuk' => 'required',
            'batas_max' => 'required',
            'batas_min' => 'required',
            'late_1' => 'required',
            'late_2' => 'required',
        ];
        $validatedData = $request->validate($rules);
        AturanPresensi::where('id', $request->id)->update($validatedData);
        return redirect('/presensi')->with('success', 'Aturan presensi berhasil diubah!');
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

        $getAturanPresensi = AturanPresensi::get();
        foreach($getAturanPresensi as $item){
            if(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', strtotime($item->batas_min))) && strtotime($data['jam_masuk']) < strtotime(date('H:i:s', strtotime($item->jam_masuk)))){
                $data['sesi'] = $item->sesi;
                $data['status'] = 'Normal';
            }elseif(strtotime($data['jam_masuk']) >= strtotime(date('H:i:s', strtotime($item->jam_masuk))) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', strtotime($item->late_1)))){
                $data['sesi'] = $item->sesi;
                $data['status'] = 'Normal';
            }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', strtotime($item->late_1))) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', strtotime($item->late_2)))){
                $data['sesi'] = $item->sesi;
                $data['status'] = 'Late 1';
            }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', strtotime($item->late_2))) && strtotime($data['jam_masuk']) <= strtotime(date('H:i:s', strtotime($item->batas_max)))){
                $data['sesi'] = $item->sesi;
                $data['status'] = 'Late 2';  
            }elseif($item->sesi == 2 && strtotime($data['jam_masuk']) > strtotime(date('H:i:s', strtotime($item->batas_max)))){
                return redirect()->back()->with('failed','Sesi telah berakhir');
            }
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

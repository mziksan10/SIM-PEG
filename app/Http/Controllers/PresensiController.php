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
    public function rekapPresensi()
    {
        return view('presensi/rekap',[
                'title' => 'Rekap Presensi',
                'data_presensi' => Presensi::latest()->get(),
        ]);
    }

    public function aturanPresensi()
    {
        return view('presensi/aturan',[
                'title' => 'Aturan Presensi',
                'data_aturanPresensi' => AturanPresensi::get(),
        ]);
    }

    public function updateAturanPresensi(Request $request){
        $rules = [
            'jam_masuk' => 'required',
            'batas_max' => 'required',
            'batas_min' => 'required',
            'late_1' => 'required',
            'late_2' => 'required',
        ];
        $validatedData = $request->validate($rules);
        AturanPresensi::where('id', $request->id)->update($validatedData);
        return back()->with('success', 'Aturan presensi berhasil diubah!');
    }

    public function export() 
    {
        return Excel::download(new PresensisExport, 'rekap-presensi-pegawai.xlsx');
    }
}

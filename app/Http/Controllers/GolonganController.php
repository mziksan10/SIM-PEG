<?php

namespace App\Http\Controllers;

use App\Exports\GolongansExport;
use App\Imports\GolongansImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Golongan;
use Illuminate\Http\Request;
use PDF;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('golongan/index', [
            'title' => 'Data Golongan',
            'data_golongan' => Golongan::get()->sortBy('golongan'),
            'jenjang' => Golongan::data_pendidikan(),
            'status' => Golongan::data_status()
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
        $validatedData = $request->validate([
            'golongan' => 'required',
            'jenjang' => 'required',
            'min_masa_kerja' => 'required|numeric',
            'max_masa_kerja' => 'nullable|numeric',
            'gaji_pokok' => 'required|numeric',
            'status' => 'required',
        ]);
        Golongan::create($validatedData);
        return redirect('/golongan')->with('success', 'Data golongan berhasil diinput!');
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
    public function edit(Golongan $golongan)
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
    public function update(Request $request, Golongan $golongan)
    {
        $rules = [
            'jenjang' => 'required',
            'min_masa_kerja' => 'required|numeric',
            'max_masa_kerja' => 'nullable|numeric',
            'gaji_pokok' => 'required|numeric',
            'status' => 'required',
        ];
        if($request->golongan != $golongan->golongan){
            $rules['golongan'] = 'required';
        }
        $validatedData = $request->validate($rules);
        Golongan::where('id', $golongan->id)->update($validatedData);
        return redirect('/golongan')->with('success', 'Data golongan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Golongan $golongan)
    {
        Golongan::destroy($golongan->id);
        return redirect('/golongan')->with('success', 'Data golongan berhasil dihapus!');
    }

    public function export() 
    {
        return Excel::download(new GolongansExport, 'Ekspor_Data_Golongan.xlsx');
    }

    public function import(Request $request) 
    {
        if(request()->file('file')){
            Excel::import(new GolongansImport, request()->file('file'));
            return redirect('/golongan')->with('success', 'Data golongan berhasil diimpor!');
        }
        
        return redirect('/golongan');
    }

    public function report(){ 
    	$pdf = PDF::loadview('golongan/report',[
                                'data_golongan' => Golongan::all(),
                            ])->setPaper('A4', 'potrait');
    	return $pdf->download('laporan-data-golongan.pdf');
    }
}

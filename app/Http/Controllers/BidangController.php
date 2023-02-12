<?php

namespace App\Http\Controllers;

use App\Exports\BidangsExport;
use App\Imports\BidangsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bidang/index', [
            'title' => 'Data Bidang',
            'data_bidang' => Bidang::orderBy('nama_bidang', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bidang/create', [
            'title' => 'Input Bidang',
        ]);
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
            'kode_bidang' => 'required',
            'nama_bidang' => 'required',
        ]);
        Bidang::create($validatedData);
        return redirect('/bidang')->with('success', 'Data bidang berhasil diinput!');
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
    public function edit(Bidang $bidang)
    {
        return view('bidang/edit', [
            'title' => 'Ubah Bidang',
            'bidang' => $bidang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bidang $bidang)
    {
        $rules = [
            'nama_bidang' => 'required'
        ];
        if($request->kode_bidang != $bidang->kode_bidang){
            $rules['kode_bidang'] = 'required|unique:bidangs';
        }
        $validatedData = $request->validate($rules);
        Bidang::where('id', $bidang->id)->update($validatedData);
        return redirect('/bidang')->with('success', 'Data bidang berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bidang $bidang)
    {
        Bidang::destroy($bidang->id);
        return redirect('/bidang')->with('success', 'Data bidang berhasil dihapus!');
    }

    public function export() 
    {
        return Excel::download(new BidangsExport, 'Ekspor_Data_Bidang.xlsx');
    }

    public function import(Request $request) 
    {
        if(request()->file('file')){
            Excel::import(new BidangsImport, request()->file('file'));
            return redirect('/bidang')->with('success', 'Data bidang berhasil diimpor!');
        }
        
        return redirect('/bidang');
    }
}

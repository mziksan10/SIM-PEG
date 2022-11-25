<?php

namespace App\Http\Controllers;

use App\Exports\JabatansExport;
use App\Imports\JabatansImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Jabatan;
use App\Models\Bidang;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jabatan/index', [
            'title' => 'Data Jabatan',
            'data_jabatan' => Jabatan::orderBy('nama_jabatan', 'ASC')->filter(request(['search']))->paginate('5')->withQueryString(),
            'data_bidang' => Bidang::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jabatan/create', [
            'title' => 'Input Jabatan'
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
        $kodeBidang = Bidang::select('kode_bidang')->where('id', $request->bidang_id)->get();
        $validatedData = $request->validate([
            'kode_jabatan' => 'required',
            'nama_jabatan' => 'required',
            'bidang_id' => 'required',
        ]);
        $validatedData['kode_bidang'] = $kodeBidang[0]->kode_bidang;
        Jabatan::create($validatedData);
        return redirect('/jabatan')->with('success', 'Data jabatan berhasil diinput!');
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
    public function edit(Jabatan $jabatan)
    {
        return view('jabatan/edit', [
            'title' => 'Ubah Jabatan',
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $rules = [
            'nama_jabatan' => 'required'
        ];
        if($request->kode_jabatan != $jabatan->kode_jabatan){
            $rules['kode_jabatan'] = 'required|unique:jabatans';
        }
        $validatedData = $request->validate($rules);
        Jabatan::where('id', $jabatan->id)->update($validatedData);
        return redirect('/jabatan')->with('success', 'Data jabatan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        Jabatan::destroy($jabatan->id);
        return redirect('/jabatan')->with('success', 'Data jabatan berhasil dihapus!');
    }

    public function export() 
    {
        return Excel::download(new JabatansExport, 'Ekspor_Data_Jabatan.xlsx');
    }

    public function import(Request $request) 
    {
        if(request()->file('file')){
            Excel::import(new JabatansImport, request()->file('file'));
            return redirect('/jabatan')->with('success', 'Data jabatan berhasil diimpor!');
        }
        
        return redirect('/jabatan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use PDF;
use Illuminate\Http\Request;
use App\Exports\PegawaisExport;
use App\Imports\PegawaisImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pegawai/index', [
            'title' => 'Data Pegawai',
            'data_pegawai' => Pegawai::latest()->filter(request(['search']))->paginate('5')->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectNIP = Pegawai::select('nip')->latest('tanggal_masuk')->first();
        if($selectNIP == null){
            $createNIP = '130041' . date('dmy') . '0001';     
        }elseif($selectNIP->get()){
            $createNIP = '130041' . date('dmy') . substr($selectNIP->get()[0]->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Input Pegawai',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'pendidikan' => Pegawai::data_pendidikan(),
            'jenis_kelamin' => Pegawai::data_jenis_kelamin(),
            'nip_baru' => $createNIP,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function cariJabatan(Request $request){
        $jabatan_id = Jabatan::where('bidang_id', $request->get('bidang_id'))->pluck('nama_jabatan', 'id');
        return response()->json($jabatan_id);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:60',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|max:255',
            'desa' => 'required|max:60',
            'kecamatan' => 'required|max:60',
            'kab_kota' => 'required|max:60',
            'provinsi' => 'required|max:60',
            'kode_pos' => 'required|max:5',
            'no_hp' => 'required|max:20',
            'email' => 'required|max:255|email',
            'pendidikan' => 'required',
            'jurusan' => 'max:60',
            'no_rekening' => 'max:20',
            'bank' => 'max:5',
            'foto' => 'image|file|max:3072',
        ]);
        if(request()->file('foto')){ 
            $validatedData['foto'] = request()->file('foto')->store('foto-profil');  
        }
        $validatedData['status'] = 'Non Aktif';
        $validatedData['tanggal_masuk'] = date_create()->format('Y-m-d');
        $validatedData['nip'] = $request->nip;
        Pegawai::create($validatedData);
        return redirect('/pegawai')->with('success', 'Data pegawai berhasil diinput!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        return view('/pegawai/show', [
            'pegawai' => $pegawai,           
            'title' => 'Detail Pegawai',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all(),
            'data_berkas' => Pegawai::find($pegawai->id)->berkas()->filter(request(['search']))->paginate('5'),
            'data_riwayatJabatan' => Pegawai::find($pegawai->id)->riwayatJabatan_()->get(),
            'jenis_berkas' => Pegawai::data_jenis_berkas(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        return view('/pegawai/edit', [
            'pegawai' => $pegawai,           
            'title' => 'Ubah Pegawai',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'status' => Pegawai::data_status(),
            'pendidikan' => Pegawai::data_pendidikan(),
            'jenis_kelamin' => Pegawai::data_jenis_kelamin()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $rules = [
            'nik' => 'required',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:60',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|max:255',
            'desa' => 'required|max:60',
            'kecamatan' => 'required|max:60',
            'kab_kota' => 'required|max:60',
            'provinsi' => 'required|max:60',
            'kode_pos' => 'required|max:5',
            'no_hp' => 'required|max:20',
            'email' => 'required|max:255|email',
            'pendidikan' => 'required',
            'jurusan' => 'required|max:60',
            'no_rekening' => 'max:20',
            'bank' => 'max:5',
            'tanggal_masuk' => 'required',
            'status' => 'required',
            'foto' => 'image|file|max:3072',
        ];
        if($request->nip != $pegawai->nip){
            $rules['nip'] = 'required|unique:pegawais';
        }
        $validatedData = $request->validate($rules);
        if(request()->file('foto')){ 
            if($request->foto_lama){
                Storage::delete($request->foto_lama);
            }
            $validatedData['foto'] = request()->file('foto')->store('foto-profil');  
        }
        Pegawai::where('id', $pegawai->id)->update($validatedData);
        return redirect('/pegawai')->with('success', 'Data pegawai berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        $getBerkas = Pegawai::find($pegawai->id)->berkas;
        if($getBerkas){
            foreach($getBerkas as $berkas){
                Storage::delete($berkas->file);
            }
            $getBerkas = Pegawai::find($pegawai->id)->berkas()->delete();  
        }

        if($pegawai->foto){
            Storage::delete($pegawai->foto);
        }
        
        RiwayatJabatan::where('pegawai_id', $pegawai->id)->delete();
        Pegawai::destroy($pegawai->id);
        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus!');
    }

    public function export() 
    {
        return Excel::download(new PegawaisExport, 'Ekspor_Data_Pegawai.xlsx');
    }

    public function import() 
    {
        if(request()->file('file')){
            Excel::import(new PegawaisImport, request()->file('file')); 
            return redirect('/pegawai')->with('success', 'Data pegawais berhasil diimpor!');
        } 
        return redirect('/pegawai');       
    }

    public function report(){ 
    	$pdf = PDF::loadview('pegawai/report',[
                                'data_pegawai' => Pegawai::all(),
                                'data_bidang' => Bidang::all(),
                                'data_jabatan' => Jabatan::all(),
                                'data_golongan' => Golongan::all(),
                            ])->setPaper('A4', 'potrait');
    	return $pdf->download('laporan-data-pegawai.pdf');
    }

    public function index_()
    {
        $pegawai = Pegawai::select('*')->where('id', session()->get('pegawai_id'))->get();
        return view('pegawai/pegawai/index',[
            'title'  => 'Profil',
            'pegawai'  => $pegawai[0],
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all(),
            'data_riwayatJabatan' => Pegawai::find(session()->get('pegawai_id'))->riwayatJabatan_()->get(),
        ]);
    }

}

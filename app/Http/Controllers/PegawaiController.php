<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPendidikan;
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
            'status' => ['1','2'],
            'data_pegawai' => Pegawai::get()->sortBy('nip'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPegawaiTetap()
    {
        $selectNIP = Pegawai::select('nip')->where('status', '1')->latest('tanggal_masuk')->first();
        if($selectNIP == null){
            $createNIP = '130041' . date('dmy') . '1' . '001'; 
        }elseif($selectNIP->get()){
            $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Form Pegawai Tetap',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'jenis_kelamin' => Pegawai::data_jenis_kelamin(),
            'data_provinces' => DB::select('SELECT * FROM provinces ORDER BY prov_name ASC'),
            'data_cities' => DB::select('SELECT * FROM cities ORDER BY city_name ASC'),
            'nip_baru' => $createNIP,
            'status' => '1',
        ]);
    }
    public function createPegawaiKontrak()
    {
        $selectNIP = Pegawai::select('nip')->where('status', '2')->latest('tanggal_masuk')->first();
        if($selectNIP == null){
            $createNIP = '130041' . date('dmy') . '2' . '001'; 
        }elseif($selectNIP->get()){
            $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Form Pegawai Kontrak',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'jenis_kelamin' => Pegawai::data_jenis_kelamin(),
            'data_provinces' => DB::select('SELECT * FROM provinces ORDER BY prov_name ASC'),
            'data_cities' => DB::select('SELECT * FROM cities ORDER BY city_name ASC'),
            'nip_baru' => $createNIP,
            'status' => '2',
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
        $getProvinsi = DB::select("SELECT prov_name FROM provinces WHERE prov_id = '$request->provinsi'");
        $getKota = DB::select("SELECT city_name FROM cities WHERE city_id = '$request->kab_kota'");
        $getKecamatan = DB::select("SELECT dis_name FROM districts WHERE dis_id = '$request->kecamatan'");
        $getDesa = DB::select("SELECT subdis_name FROM subdistricts WHERE subdis_id = '$request->desa'");
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
            'foto' => 'image|file|max:1024',
        ]);
        if(request()->file('foto')){ 
            $validatedData['foto'] = request()->file('foto')->store('foto-profil');  
        }
        $validatedData['tempat_lahir'] = ucwords(strtolower($request->tempat_lahir));
        $validatedData['provinsi'] = ucwords(strtolower($getProvinsi[0]->prov_name));
        $validatedData['kab_kota'] = ucwords(strtolower($getKota[0]->city_name));
        $validatedData['kecamatan'] = ucwords(strtolower($getKecamatan[0]->dis_name));
        $validatedData['desa'] = ucwords(strtolower($getDesa[0]->subdis_name));
        $validatedData['tanggal_masuk'] = date_create()->format('Y-m-d');
        $validatedData['nip'] = $request->nip;
        $validatedData['status'] = $request->status;
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
            'data_riwayatPendidikan' => Pegawai::find($pegawai->id)->riwayatPendidikan_()->get(),
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
            'jenis_kelamin' => Pegawai::data_jenis_kelamin(),
            'data_provinces' => DB::select('SELECT * FROM provinces ORDER BY prov_name ASC'),
            'data_cities' => DB::select('SELECT * FROM cities ORDER BY city_name ASC'),
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
            'tanggal_masuk' => 'required',
            'foto' => 'image|file|max:1024',
        ];
        $validatedData = $request->validate($rules);
        if($request->status != $pegawai->status){
            $selectNIP = Pegawai::select('nip')->where('status', '1')->latest('tanggal_masuk')->first();
            if($selectNIP == null){
                $createNIP = '130041' . date('dmy') . '1' . '001'; 
            }else{
                $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
            }
            $validatedData['nip'] = $createNIP;  
            $validatedData['status'] = $request->status;  
        }
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
        
        RiwayatPendidikan::where('pegawai_id', $pegawai->id)->delete();
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

    public function cariKota(Request $request){
        $getKota = DB::select("SELECT city_name, city_id FROM cities WHERE prov_id = '$request->provinsi'");
        return response()->json($getKota);
    }

    public function cariKecamatan(Request $request){
        $getKecamatan = DB::select("SELECT dis_name, dis_id FROM districts WHERE city_id = '$request->kab_kota'");
        return response()->json($getKecamatan);
    }

    public function cariDesa(Request $request){
        $getDesa = DB::select("SELECT subdis_name, subdis_id FROM subdistricts WHERE dis_id = '$request->kecamatan'");
        return response()->json($getDesa);
    }

    public function cariJabatan(Request $request){
        $jabatan_id = Jabatan::where('bidang_id', $request->get('bidang_id'))->pluck('nama_jabatan', 'id');
        return response()->json($jabatan_id);
    }

    public function cariGolongan(Request $request){
        $getPegawai = Pegawai::where('nip', $request->get('nip'))->pluck('id');
        $getJenjang = RiwayatPendidikan::where('pegawai_id', $getPegawai)->latest('tahun_lulus')->pluck('jenjang');
        $golongan_id = Golongan::where('jenjang', $getJenjang)->get();
        return response()->json($golongan_id);
    }

    public function cariPegawai(Request $request){
        $pegawai = Pegawai::orderby('nama','asc')->select('nip','nama')->where('nip', 'like', '%' .$request->search . '%')->limit(5)->get();
        $response = array();
        foreach($pegawai as $item){
           $response[] = array("value"=>$item->nip,"label"=>$item->nip . ' - ' . $item->nama);
        }
  
        return response()->json($response);
    }

}

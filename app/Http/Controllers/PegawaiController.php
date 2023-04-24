<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPendidikan;
use App\Models\Berkas;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Desa;
use PDF;
use Illuminate\Http\Request;
use App\Exports\PegawaisExport;
use App\Imports\PegawaisImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use DateTime;

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
            'status' => ['1', '2', '3'],
            'data_pegawai' => Pegawai::get()->sortBy('nip'),
            'golongan' => Golongan::all(),
            'data_pegawaiTetap' => Pegawai::where('status', '=', '1')->count(),
            'data_pegawaiKontrak' => Pegawai::where('status', '=', '2')->count(),
            'data_pegawaiMagang' => Pegawai::where('status', '=', '3')->count(),
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
        if ($selectNIP == null) {
            $createNIP = '130041' . date('dmy') . '1' . '001';
        } elseif ($selectNIP->get()) {
            $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Form Pegawai Tetap',
            'photo' => 'logo_piksi.png',
            'bidang' => Bidang::all(),
            'jabatan' => Jabatan::all(),
            'golongan' => Golongan::all()->sortBy('golongan'),
            'jenisKelamin' => Pegawai::jenisKelamin(),
            'provinsi' => Provinsi::all()->sortBy('prov_name'),
            'kota' => Kota::all()->sortBy('city_name'),
            'kecamatan' => Kecamatan::all()->sortBy('dis_name'),
            'desa' => Desa::all()->sortBy('subdis_name'),
            'nip_baru' => $createNIP,
            'status' => '1',
            'jenjang' => RiwayatPendidikan::jenjang(),
            'statusPernikahan' => Pegawai::statusPernikahan(),
            'statusKepemilikanRumah' => Pegawai::statusKepemilikanRumah(),
        ]);
    }

    public function createPegawaiKontrak()
    {
        $selectNIP = Pegawai::select('nip')->where('status', '2')->latest('tanggal_masuk')->first();
        if ($selectNIP == null) {
            $createNIP = '130041' . date('dmy') . '2' . '001';
        } elseif ($selectNIP->get()) {
            $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Form Pegawai Kontrak',
            'photo' => 'logo_piksi.png',
            'bidang' => Bidang::all(),
            'jabatan' => Jabatan::all(),
            'golongan' => Golongan::all()->sortBy('golongan'),
            'jenisKelamin' => Pegawai::jenisKelamin(),
            'provinsi' => Provinsi::all(),
            'kota' => Kota::all(),
            'kecamatan' => Kecamatan::all(),
            'desa' => Desa::all(),
            'nip_baru' => $createNIP,
            'status' => '2',
            'jenjang' => RiwayatPendidikan::jenjang(),
            'statusPernikahan' => Pegawai::statusPernikahan(),
            'statusKepemilikanRumah' => Pegawai::statusKepemilikanRumah(),
        ]);
    }

    public function createPegawaiMagang()
    {
        $selectNIP = Pegawai::select('nip')->where('status', '2')->latest('tanggal_masuk')->first();
        if ($selectNIP == null) {
            $createNIP = '130041' . date('dmy') . '2' . '001';
        } elseif ($selectNIP->get()) {
            $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
        }
        return view('/pegawai/create', [
            'title' => 'Form Pegawai Magang',
            'photo' => 'logo_piksi.png',
            'bidang' => Bidang::all(),
            'jabatan' => Jabatan::all(),
            'golongan' => Golongan::all()->sortBy('golongan'),
            'jenisKelamin' => Pegawai::jenisKelamin(),
            'provinsi' => Provinsi::all(),
            'kota' => Kota::all(),
            'kecamatan' => Kecamatan::all(),
            'desa' => Desa::all(),
            'nip_baru' => $createNIP,
            'status' => '3',
            'jenjang' => RiwayatPendidikan::jenjang(),
            'statusPernikahan' => Pegawai::statusPernikahan(),
            'statusKepemilikanRumah' => Pegawai::statusKepemilikanRumah(),
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
        // VALIDASI DATA PRIBADI
        $validatedData = $request->validate([
            'nik' => 'required|max:16',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:60',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|max:255',
            'status_kepemilikan_rumah' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kab_kota' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required|max:5',
            'no_hp' => 'required|max:20',
            'email' => 'nullable|max:255|email',
            'foto' => 'image|file|max:1024',
            'status_pernikahan' => 'required',
            'instansi_sebelumnya' => 'nullable',
            'pekerjaan_sebelumnya' => 'nullable',
            'jabatan_sebelumnya' => 'nullable',
            'masa_jabatan_sebelumnya' => 'nullable',
        ]);
        if (request()->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->storeAs(
                'foto-profil',
                $request->nip . '.' . $request->file('foto')->extension()
            );
        }
        $validatedData['tanggal_masuk'] = date_create()->format('Y-m-d');
        $validatedData['nip'] = $request->nip;
        $validatedData['status'] = $request->status;
        // dd($validatedData['foto']);

        // VALIDASI DATA PENDIDIKAN TERAKHIR
        $validatedDataPendidikan = $request->validate([
            'jenjang' => 'required',
            'jurusan' => 'nullable',
            'institusi' => 'required',
            'tahun_lulus' => 'required',
            'scan_ijazah' => 'mimes:pdf|max:1024',
        ]);
        if (request()->file('scan_ijazah')) {
            $validatedDataPendidikan['scan_ijazah'] = request()->file('scan_ijazah')->store('berkas-pegawai');
        }

        // VALIDASI DATA JABATAN TERAKHIR
        $validatedDataJabatan = $request->validate([
            'bidang_id' => 'required',
            'jabatan_id' => 'required',
            'scan_sk' => 'mimes:pdf|max:1024',
        ]);
        if (request()->file('scan_sk')) {
            $validatedDataJabatan['scan_sk'] = request()->file('scan_sk')->store('berkas-pegawai');
        }

        // TAMBAH PEGAWAI
        Pegawai::create($validatedData);
        $pegawaiId = Pegawai::select('id')->where('nip', $request->nip)->get();

        // TAMBAH PENDIDIKAN TERAKHIR
        $validatedDataPendidikan['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatPendidikan::create($validatedDataPendidikan);

        // TAMBAH JABATAN TERAKHIR
        if ($request->status == 1) {
            $status = "Tetap";
        } elseif ($request->status == 2 || $request->status == 3) {
            $status = "Kontrak";
        }
        $validatedDataJabatan['golongan_id'] = Golongan::where('jenjang', $request->jenjang)->where('status', $status)->pluck('id')->first();
        $validatedDataJabatan['tmt_golongan'] = date_create()->format('Y-m-d');
        $validatedDataJabatan['tmt_bekerja'] = date_create()->format('Y-m-d');
        $validatedDataJabatan['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatJabatan::create($validatedDataJabatan);

        return redirect(route('pegawai'))->with('success', 'Data pegawai berhasil diinput!');
    }

    public function storeRiwayatPendidikan(Request $request)
    {
        $pegawaiId = Pegawai::select('id')->where('nip', $request->nip)->get();
        $validatedData = $request->validate([
            'jenjang' => 'required',
            'jurusan' => 'nullable',
            'institusi' => 'required',
            'tahun_lulus' => 'required',
            'scan_ijazah' => 'mimes:pdf|max:1024',
        ]);
        if (request()->file('scan_ijazah')) {
            $validatedData['scan_ijazah'] = request()->file('scan_ijazah')->store('berkas-pegawai');
        } else {
            $validatedData['scan_ijazah'] = 0;
        }

        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatPendidikan::create($validatedData);
        return back()->with('success', 'Data riwayat pendidikan berhasil diinput!');
    }

    public function storeRiwayatJabatan(Request $request)
    {
        $pegawaiId = Pegawai::select('id')->where('nip', $request->nip)->get();
        $validatedData = $request->validate([
            'golongan_id' => 'required',
            'bidang_id' => 'required',
            'jabatan_id' => 'required',
            'scan_sk' => 'mimes:pdf|max:1024',
        ]);
        if (request()->file('scan_sk')) {
            $validatedData['scan_sk'] = request()->file('scan_sk')->store('berkas-pegawai');
        } else {
            $validatedData['scan_sk'] = 0;
        }
        if ($request->status == 1) {
            $status = "Tetap";
        } elseif ($request->status == 2 || $request->status == 3) {
            $status = "Kontrak";
        }
        $validatedData['tmt_golongan'] = date_create()->format('Y-m-d');
        $validatedData['tmt_bekerja'] = date_create()->format('Y-m-d');
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        RiwayatJabatan::create($validatedData);
        return back()->with('success', 'Data riwayat jabatan berhasil diinput!');
    }

    public function storeBerkas(Request $request)
    {
        $pegawaiId = Pegawai::select('id')->where('nip', $request->nip)->get();
        $validatedData = $request->validate([
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|max:1024',
        ]);
        $validatedData['pegawai_id'] = $pegawaiId[0]->id;
        if (request()->file('file')) {
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');
        }
        Berkas::create($validatedData);
        return back()->with('success', 'Data berkas berhasil diinput!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        $tanggal_masuk = new DateTime("$pegawai->tanggal_masuk");
        $sekarang = new DateTime("today");
        if ($tanggal_masuk > $sekarang) {
            $thn = "0";
            $bln = "0";
            $tgl = "0";
        }
        $thn = $sekarang->diff($tanggal_masuk)->y;
        $bln = $sekarang->diff($tanggal_masuk)->m;
        $tgl = $sekarang->diff($tanggal_masuk)->d;

        $pegawaiBerulangTahun = [];
        $pegawaiNaikGolongan = [];
        if (date('d F', strtotime($pegawai->tanggal_lahir)) == date('d F', strtotime(now()))) {
            $pegawaiBerulangTahun[] = true;
        }
        if ($pegawai->riwayatJabatan != null) {
            if ($thn > $pegawai->riwayatJabatan->golongan->min_masa_kerja && $thn != $pegawai->riwayatJabatan->golongan->max_masa_kerja) {
                $pegawaiNaikGolongan[] = $pegawai;
            }
        }
        return view('/pegawai/show', [
            'pegawai' => $pegawai,
            'title' => 'Detail Pegawai',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all(),
            'data_jenisBerkas' => Pegawai::find($pegawai->id)->berkas()->filter(request(['search']))->paginate('5'),
            'data_riwayatJabatan' => Pegawai::find($pegawai->id)->riwayatJabatan_()->get(),
            'data_riwayatPendidikan' => Pegawai::find($pegawai->id)->riwayatPendidikan_()->get(),
            'jenisBerkas' => Berkas::jenisBerkas(),
            'lamaBekerja' => [$thn, $bln, $tgl],
            'jenjang' => RiwayatPendidikan::jenjang(),
            'pegawaiBerulangTahun' => $pegawaiBerulangTahun,
            'pegawaiNaikGolongan' => $pegawaiNaikGolongan,
            'provinsi' => Provinsi::select('prov_name')->where('prov_id', $pegawai->provinsi)->get(),
            'kota' => Kota::select('city_name')->where('city_id', $pegawai->kab_kota)->get(),
            'kecamatan' => Kecamatan::select('dis_name')->where('dis_id', $pegawai->kecamatan)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        return view('/pegawai/edit', [
            'pegawai' => $pegawai,
            'title' => 'Edit Detail Pribadi Pegawai',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'status' => Pegawai::status(),
            'jenjang' => RiwayatPendidikan::jenjang(),
            'jenisKelamin' => Pegawai::jenisKelamin(),
            'data_provinces' => Provinsi::all(),
            'data_cities' => Kota::all(),
            'data_districts' => Kecamatan::all(),
            'data_subdistricts' => Desa::all(),
            'statusPernikahan' => Pegawai::statusPernikahan(),
            'statusKepemilikanRumah' => Pegawai::statusKepemilikanRumah(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $getProvinsi = DB::select("SELECT prov_name FROM provinces WHERE prov_id = '$request->provinsi'");
        $getKota = DB::select("SELECT city_name FROM cities WHERE city_id = '$request->kab_kota'");
        $getKecamatan = DB::select("SELECT dis_name FROM districts WHERE dis_id = '$request->kecamatan'");
        $getDesa = DB::select("SELECT subdis_name FROM subdistricts WHERE subdis_id = '$request->desa'");
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
            'status_pernikahan' => 'required',
        ];
        $validatedData = $request->validate($rules);
        if ($request->status == 2) {
            $selectNIP = Pegawai::select('nip')->where('status', '1')->latest('tanggal_masuk')->first();
            if ($selectNIP == null) {
                $createNIP = '130041' . date('dmy') . '1' . '001';
            } else {
                $createNIP = '130041' . date('dmy') . substr($selectNIP->nip, -4) + 1;
            }
            $validatedData['nip'] = $createNIP;
            $validatedData['status'] = $request->status;
        } elseif ($request->status == 0) {
            $validatedData['status'] = $request->status;
        }
        if (request()->file('foto')) {
            if ($request->foto_lama) {
                Storage::delete($request->foto_lama);
            }
            $validatedData['foto'] = request()->file('foto')->store('foto-profil');
        }
        $validatedData['tempat_lahir'] = ucwords(strtolower($request->tempat_lahir));
        if ($request->provinsi != $pegawai->provinsi) {
            $validatedData['provinsi'] = ucwords(strtolower($getProvinsi[0]->prov_name));
        }
        if ($request->kab_kota != $pegawai->kab_kota) {
            $validatedData['kab_kota'] = ucwords(strtolower($getKota[0]->city_name));
        }
        if ($request->kecamatan != $pegawai->kecamatan) {
            $validatedData['kecamatan'] = ucwords(strtolower($getKecamatan[0]->dis_name));
        }
        if ($request->desa != $pegawai->desa) {
            $validatedData['desa'] = ucwords(strtolower($getDesa[0]->subdis_name));
        }
        Pegawai::where('id', $pegawai->id)->update($validatedData);
        return redirect(route('showPegawai', $id))->with('success', 'Detail pribadi berhasil diubah!');
    }

    public function updateRiwayatPendidikan(Request $request, $id)
    {
        $riwayatPendidikan = RiwayatPendidikan::find($id);
        $rules = [
            'jenjang' => 'required',
            'jurusan' => 'nullable',
            'institusi' => 'required',
            'tahun_lulus' => 'required',
            'scan_ijazah' => 'mimes:pdf|max:1024',
        ];
        $validatedData = $request->validate($rules);
        if (request()->file('scan_ijazah')) {
            if ($request->scan_ijazah) {
                Storage::delete($request->scan_ijazah);
            }
            $validatedData['scan_ijazah'] = request()->file('scan_ijazah')->store('berkas-pegawai');
        }
        RiwayatPendidikan::where('id', $riwayatPendidikan->id)->update($validatedData);
        return back()->with('success', 'Detail pendidikan berhasil diubah!');
    }

    public function updateRiwayatJabatan(Request $request, $id)
    {
        $riwayatJabatan = RiwayatJabatan::find($id);
        $rules = [
            'bidang_id' => 'required',
            'jabatan_id' => 'required',
            'golongan_id' => 'required',
            'tmt_golongan' => 'required',
            'tmt_bekerja' => 'required',
            'scan_sk' => 'mimes:pdf|file|max:1024',
        ];
        $validatedData = $request->validate($rules);
        if (request()->file('scan_sk')) {
            if ($request->file_lama) {
                Storage::delete($request->scan_sk_lama);
            }
            $validatedData['scan_sk'] = request()->file('scan_sk')->store('berkas-pegawai');
        }
        if ($request->status == 1) {
            $status = "Tetap";
        } elseif ($request->status == 2 | $request->status == 3) {
            $status = "Kontrak";
        }
        $validatedData['golongan_id'] = Golongan::where('jenjang', $request->jenjang)->where('status', $status)->pluck('id')->first();
        RiwayatJabatan::where('id', $riwayatJabatan->id)->update($validatedData);
        return back()->with('success', 'Detail jabatan berhasil diubah!');
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
        if ($getBerkas) {
            foreach ($getBerkas as $berkas) {
                Storage::delete($berkas->file);
            }
            $getBerkas = Pegawai::find($pegawai->id)->berkas()->delete();
        }

        if ($pegawai->foto) {
            Storage::delete($pegawai->foto);
        }

        RiwayatPendidikan::where('pegawai_id', $pegawai->id)->delete();
        RiwayatJabatan::where('pegawai_id', $pegawai->id)->delete();
        Pegawai::destroy($pegawai->id);
        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus!');
    }
    public function destroyBerkas($id)
    {
        $getBerkas = Berkas::select('*')->where('id', $id)->get();
        foreach ($getBerkas as $berkas)
            if ($berkas->file) {
                Storage::delete($berkas->file);
            }
        Berkas::destroy($berkas->id);
        return redirect()->back()->with('success', 'Data berkas berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new PegawaisExport, 'Ekspor_Data_Pegawai.xlsx');
    }

    public function import()
    {
        if (request()->file('file')) {
            Excel::import(new PegawaisImport, request()->file('file'));
            return redirect('/pegawai')->with('success', 'Data pegawais berhasil diimpor!');
        }
        return redirect('/pegawai');
    }

    public function report()
    {
        $pdf = PDF::loadview('pegawai/report', [
            'data_pegawai' => Pegawai::all(),
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all(),
        ])->setPaper('A4', 'potrait');
        return $pdf->download('laporan-data-pegawai.pdf');
    }

    public function cariKota(Request $request)
    {
        $getKota = DB::select("SELECT city_name, city_id FROM cities WHERE prov_id = '$request->provinsi'");
        return response()->json($getKota);
    }

    public function cariKecamatan(Request $request)
    {
        $getKecamatan = DB::select("SELECT dis_name, dis_id FROM districts WHERE city_id = '$request->kab_kota'");
        return response()->json($getKecamatan);
    }

    public function cariDesa(Request $request)
    {
        $getDesa = DB::select("SELECT subdis_name, subdis_id FROM subdistricts WHERE dis_id = '$request->kecamatan'");
        return response()->json($getDesa);
    }

    public function cariJabatan(Request $request)
    {
        $jabatan_id = Jabatan::where('bidang_id', $request->get('bidang_id'))->pluck('nama_jabatan', 'id');
        return response()->json($jabatan_id);
    }

    public function cariGolongan(Request $request)
    {
        $getPegawai = Pegawai::select('*')->where('nip', $request->get('nip'))->first();
        $getJenjang = RiwayatPendidikan::select('*')->where('pegawai_id', $getPegawai->id)->latest()->first();
        if ($getPegawai->status == 1) {
            $status = "Tetap";
        } elseif ($getPegawai->status == 2 || $getPegawai->status == 3) {
            $status = "Kontrak";
        }
        $golongan_id = Golongan::where('jenjang', $getJenjang->jenjang)->where('status', $status)->where('min_masa_kerja', '>=',  $request->get('lama_bekerja'))->get();
        return response()->json($golongan_id);
    }

    public function cariPegawai(Request $request)
    {
        $pegawai = Pegawai::orderby('nama', 'asc')->select('nip', 'nama')->where('nip', 'like', '%' . $request->search . '%')->limit(5)->get();
        $response = array();
        foreach ($pegawai as $item) {
            $response[] = array("value" => $item->nip, "label" => $item->nip . ' - ' . $item->nama);
        }

        return response()->json($response);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPendidikan;
use App\Models\Berkas;
use App\Models\Presensi;
use App\Models\AturanPresensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Carbon\Carbon;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function profil()
    {
        $pegawai = Pegawai::find(session()->get('pegawai_id'));
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
        if(date('d F', strtotime($pegawai->tanggal_lahir)) == date('d F', strtotime(now()))){
            $pegawaiBerulangTahun[] = true;
        }
        if($pegawai->riwayatJabatan != null){
            if($thn > $pegawai->riwayatJabatan->golongan->min_masa_kerja && $thn != $pegawai->riwayatJabatan->golongan->max_masa_kerja){
                $pegawaiNaikGolongan[] = $pegawai;
            }
        }
        return view('karyawan/profil',[
            'title'  => 'Profil',
            'pegawai' => $pegawai,           
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
        ]);
    }

    public function editProfil($id){
        $pegawai = Pegawai::find($id);
        return view('/karyawan/edit-profil', [
            'pegawai' => $pegawai,           
            'title' => 'Edit Detail Pribadi',
            'photo' => 'logo_piksi.png',
            'data_bidang' => Bidang::all(),
            'data_jabatan' => Jabatan::all(),
            'data_golongan' => Golongan::all()->sortBy('golongan'),
            'status' => Pegawai::status(),
            'statusJenjang' => Pegawai::statusJenjang(),
            'jenisKelamin' => Pegawai::jenisKelamin(),
            'data_provinces' => DB::select('SELECT * FROM provinces ORDER BY prov_name ASC'),
            'data_cities' => DB::select('SELECT * FROM cities ORDER BY city_name ASC'),
            'statusPernikahan' => Pegawai::statusPernikahan(),
        ]);
    }

    public function updateProfil(Request $request, $id){
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
            'foto' => 'image|file|max:1024',
            'status_pernikahan' => 'required',
        ];
        $validatedData = $request->validate($rules);
        if(request()->file('foto')){ 
            if($request->foto_lama){
                Storage::delete($request->foto_lama);
            }
            $validatedData['foto'] = request()->file('foto')->store('foto-profil');  
        }
        $validatedData['tempat_lahir'] = ucwords(strtolower($request->tempat_lahir));
        if($request->provinsi != $pegawai->provinsi){
            $validatedData['provinsi'] = ucwords(strtolower($getProvinsi[0]->prov_name));
        }
        if($request->kab_kota != $pegawai->kab_kota){
        $validatedData['kab_kota'] = ucwords(strtolower($getKota[0]->city_name));
        }
        if($request->kecamatan != $pegawai->kecamatan){
        $validatedData['kecamatan'] = ucwords(strtolower($getKecamatan[0]->dis_name));
        }
        if($request->desa != $pegawai->desa){
        $validatedData['desa'] = ucwords(strtolower($getDesa[0]->subdis_name));
        }
        Pegawai::where('id', $pegawai->id)->update($validatedData);
        return redirect(route('profil'))->with('success', 'Detail pribadi berhasil diubah!');
    }

    public function pemberkasan(){
        return view ('karyawan/pemberkasan',[
            'title' => 'Pemberkasan',
            'data_berkas' => Berkas::where('pegawai_id', session()->get('pegawai_id'))->get(),
            'jenisBerkas' => Berkas::jenisBerkas(),
        ]);
    }

    public function storePemberkasan(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_berkas' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|file|max:1024',
        ]);
        $validatedData['pegawai_id'] = $request->pegawai_id;
        if(request()->file('file')){ 
            $validatedData['file'] = request()->file('file')->store('berkas-pegawai');  
        }
        Berkas::create($validatedData);
        return back()->with('success', 'Berkas berhasil diinput!');
    }

    public function destroyPemberkasan($id){
        $getBerkas = Berkas::select('*')->where('id', $id)->get();
        foreach($getBerkas as $berkas)
        if($berkas->file){
            Storage::delete($berkas->file);
        }
        Berkas::destroy($berkas->id);
        return back()->with('success', 'Berkas berhasil dihapus!');
    }

    public function presensi(){
        $presensi = Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->first();
        return view('karyawan/presensi',[
            'title' => 'Presensi',
            'presensi' => $presensi,
            'data_presensi' => Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('Y-m-d'))->get(),
            'data_kehadiranBulanIni' => Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('m'))->get(),
            'jumlah_kehadiranBulanIni' => Presensi::wherePegawaiId(session()->get('pegawai_id'))->whereTanggal(date('m'))->count()
        ]);
    }

    public function absenMasuk(Request $request)
    {
        $data['jam_masuk'] = date('H:i:s');
        $data['tanggal'] = date('Y-m-d');
        $data['pegawai_id'] = session()->get('pegawai_id');
        $data['sesi'] = null;

        $getAturanPresensi = AturanPresensi::get();
        foreach($getAturanPresensi as $item){
            if($item->sesi == 1){
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
                }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', strtotime($item->batas_max))) && $item->sesi == 2){
                    return back()->with('failed','Sesi telah berakhir 1');
                }
            }elseif($item->sesi == 2){
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
                }elseif(strtotime($data['jam_masuk']) > strtotime(date('H:i:s', strtotime($item->batas_max)))){
                    return back()->with('failed','Sesi telah berakhir 2');
                }
            }
        }
        if($data['sesi'] == null){
            return back()->with('failed','Sesi telah berakhir');
        }
        Presensi::create($data);
        return redirect()->back()->with('success','Absen masuk berhasil!');
    }

    public function absenPulang(Presensi $presensi)
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

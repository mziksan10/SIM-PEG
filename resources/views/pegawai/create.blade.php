@extends('layouts/main')
@section('container')
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <div class="col">
        Home / <a href="#">{{ $title }}</a>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <form action="{{ route('importPegawai') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text ml-1">Import</span>
                </div>
                <input type="file" name="file" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-warning mr-1" type="submit"><i class="fas fa-upload fa-sm"></i></button>
                </div>
            </div>
        </form>
    </ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <!-- DataTales Example -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <center>
                        FORMULIR PENDAFTARAN PEGAWAI <br>
                        POLITEKNIK PIKSI GANESHA
                    </center>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <small>
                                    <b>Perhatian</b>
                                    <ul>
                                        <li>Untuk menambahkan data pegawai lama gunakan fitur import pegawai.</li>
                                        <li>NIP sudah di generate secara otomatis oleh sistem.</li>
                                        <li>Ukuran foto tidak boleh lebih dari 1 MB.</li>
                                        <li>Penulisan nama gelar harus benar.</li>
                                        <li>Format file scan SK/Ijazah harus PDF.</li>
                                    </ul>
                                </small>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('storePegawai') }}" method="POST" enctype="multipart/form-data">
                                @method('post')
                                @csrf
                                <!-- DETAIL PRIBADI -->
                                <div class="card mb-3">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col-8 d-flex justify-content-start">
                                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-user"></i> Detail Pribadi</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="status" value="@if(!old('status')) {{ $status }} @else {{ old('status') }} @endif" readonly="readonly">
                                        <div class="form-row">
                                            <div class="col-lg-2 col-md-6">
                                                <div class="img-thumbnail modal-dialog-centered justify-content-center bg-light mb-3">
                                                    <div style="max-height: 500px; max-width: 250px; overflow: hidden;">
                                                        <img class="img-preview mb-2" style="height: 300px; width: 240px; overflow: hidden;">
                                                        <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" onchange="previewImage()">
                                                    </div>
                                                </div>
                                                @error('foto')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-2 col-md-6">
                                                <label>NIP</label>
                                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="@if(!old('nip')) {{ $nip_baru }} @else {{ old('nip') }} @endif" readonly="readonly">
                                                @error('nip')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-6">
                                                <label>NIK</label>
                                                <input type="number" min="0" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" autofocus>
                                                @error('nik')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                                @error('nama')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4 col-md-8">
                                                <label>Tempat Lahir</label>
                                                <select name="tempat_lahir" class="select2 form-control @error('tempat_lahir') is-invalid @enderror">
                                                    <option value="" selected>Pilih..</option>
                                                    @foreach($kota as $item)
                                                    @if(old('tempat_lahir') == $item->city_id)
                                                    <option value="{{ $item->city_id }}" selected>{{ $item->city_name }}</option>
                                                    @else
                                                    <option value="{{ $item->city_id }}">{{ $item->city_name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('tempat_lahir')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-4">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                                @error('tanggal_lahir')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-6">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                                    <option value="" selected>Pilih..</option>
                                                    @foreach($jenisKelamin as $item)
                                                    @if(old('jenis_kelamin') == $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('pendidikan')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-6">
                                                <label>Status Pernikahan</label>
                                                <select name="status_pernikahan" class="form-control @error('status_pernikahan') is-invalid @enderror">
                                                    <option value="" selected>Pilih..</option>
                                                    @foreach($statusPernikahan as $item)
                                                    @if(old('status_pernikahan') == $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('status_pernikahan')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6 col-md-8">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                                @error('alamat')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-4">
                                                <label>Status Kepemilikan Rumah (Alamat)</label>
                                                <select id="status_kepemilikan_rumah" name="status_kepemilikan_rumah" class="form-control @error('status_kepemilikan_rumah') is-invalid @enderror">
                                                    <option value="" selected>Pilih..</option>
                                                    @foreach($statusKepemilikanRumah as $item)
                                                    @if(old('status_kepemilikan_rumah') == $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('status_kepemilikan_rumah')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-lg-3 col-md-6">
                                                <label>Provinsi</label>
                                                <select id="provinsi" name="provinsi" class="select2 form-control @error('provinsi') is-invalid @enderror">
                                                    <option value="" selected>Pilih..</option>
                                                    @foreach($provinsi as $item)
                                                    @if(old('provinsi') == $item->prov_id)
                                                    <option value="{{ $item->prov_id }}" selected>{{ $item->prov_name }}</option>
                                                    @else
                                                    <option value="{{ $item->prov_id }}">{{ $item->prov_name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('provinsi')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-3 col-md-6">
                                                <label>Kabupaten/Kota</label>
                                                <select id="kab_kota" name="kab_kota" class="select2 form-control @error('kab_kota') is-invalid @enderror">
                                                    @if(old('kab_kota'))
                                                    @foreach($kota as $item)
                                                    @if($item->city_id == old('kab_kota'))
                                                    <option value="{{ $item->city_id }}" selected>{{ $item->city_name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <option value="" selected>Pilih..</option>
                                                    @endif
                                                </select>
                                                @error('kab_kota')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-4">
                                                <label>Kecamatan</label>
                                                <select id="kecamatan" name="kecamatan" class="select2 form-control @error('kecamatan') is-invalid @enderror">
                                                    @if(old('kecamatan'))
                                                    @foreach($kecamatan as $item)
                                                    @if($item->dis_id == old('kecamatan'))
                                                    <option value="{{ $item->dis_id }}" selected>{{ $item->dis_name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <option value="" selected>Pilih..</option>
                                                    @endif
                                                </select>
                                                @error('kecamatan')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-4">
                                                <label>Desa</label>
                                                <select id="desa" name="desa" class="select2 form-control @error('desa') is-invalid @enderror">
                                                    @if(old('desa'))
                                                    @foreach($desa as $item)
                                                    @if($item->subdis_id == old('desa'))
                                                    <option value="{{ $item->subdis_id }}" selected>{{ $item->subdis_name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <option value="" selected>Pilih..</option>
                                                    @endif
                                                </select>
                                                @error('desa')
                                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-2 col-md-4">
                                                <label>Kode Pos</label>
                                                <input type="number" min="0" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos') }}">
                                                @error('kode_pos')
                                                <div class=" invalid-feedback ml-3">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-4 col-md-6">
                                                <label>No. HP</label>
                                                <input type="number" min="0" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}">
                                                @error('no_hp')
                                                <div class=" invalid-feedback ml-3">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-lg-4 col-md-6">
                                                <label>Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" style="text-transform:lowercase" oninput="this.value = this.value.toLowerCase()">
                                                @error('email')
                                                <div class=" invalid-feedback ml-3">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- DETAIL PENGALAMAN KERJA -->
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-8 d-flex justify-content-start">
                                    <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-business-time"></i> Pengalaman Kerja Sebelumnya</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-6">
                                    <label>Nama Instansi</label>
                                    <input type="text" class="form-control @error('instansi_sebelumnya') is-invalid @enderror" name="instansi_sebelumnya" value="{{ old('instansi_sebelumnya') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('instansi_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control @error('pekerjaan_sebelumnya') is-invalid @enderror" name="pekerjaan_sebelumnya" value="{{ old('pekerjaan_sebelumnya') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('pekerjaan_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control @error('jabatan_sebelumnya') is-invalid @enderror" name="jabatan_sebelumnya" value="{{ old('jabatan_sebelumnya') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('jabatan_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-2 col-md-2">
                                    <label>Masa Jabatan</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control @error('masa_jabatan_sebelumnya') is-invalid @enderror" name="masa_jabatan_sebelumnya" value="{{ old('masa_jabatan_sebelumnya') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Tahun</span>
                                        </div>
                                    </div>
                                    @error('masa_jabatan_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DETAIL PENDIDIKAN -->
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-8 d-flex justify-content-start">
                                    <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-graduation-cap"></i> Detail Pendidikan</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-2 col-md-2">
                                    <label>Tahun Lulus</label>
                                    <input type="number" min="0" class="form-control @error('tahun_lulus') is-invalid @enderror" name="tahun_lulus" value="{{ old('tahun_lulus') }}">
                                    @error('tahun_lulus')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-2 col-md-4">
                                    <label>Jenjang</label>
                                    <select id="jenjang" name="jenjang" class="form-control @error('jenjang') is-invalid @enderror">
                                        <option value="" selected>Pilih..</option>
                                        @foreach($jenjang as $item)
                                        @if(old('jenjang') == $item)
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                        @else
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('jenjang')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label>Jurusan</label>
                                    <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('jurusan')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label>Nama Institusi</label>
                                    <input type="text" class="form-control @error('institusi') is-invalid @enderror" name="institusi" value="{{ old('institusi') }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('institusi')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label>Upload Scan Ijazah</label>
                                    <input type="file" class="form-control @error('scan_ijazah') is-invalid @enderror" name="scan_ijazah">
                                    @error('scan_ijazah')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DETAIL JABATAN -->
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-8 d-flex justify-content-start">
                                    <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-briefcase"></i> Detail Jabatan</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Bidang</label>
                                    <select id="bidang_id" name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror">
                                        <option value="" selected>Pilih..</option>
                                        @foreach($bidang as $item)
                                        @if(old('bidang_id') == $item->id)
                                        <option value="{{ $item->id }}" selected>{{ $item->nama_bidang }}</option>
                                        @else
                                        <option value="{{ $item->id }}">{{ $item->nama_bidang }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('bidang_id')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Jabatan</label>
                                    <select id="jabatan_id" name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
                                        <option value="" selected>Pilih..</option>
                                    </select>
                                    @error('jabatan_id')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-2 col-md-4">
                                    <label>TMT Jabatan</label>
                                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-4 col-md-6">
                                    <label>Upload Scan SK</label>
                                    <input type="file" class="form-control @error('scan_sk') is-invalid @enderror" name="scan_sk" value="{{ old('scan_sk') }}">
                                    @error('scan_sk')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="float-right col-md-2 btn btn-primary ml-2"><i class="fas fa-paper-plane"></i> Submit</button>
                    <button type="reset" class="float-right col-md-2 btn btn-secondary"><i class="fas fa-redo"></i> Reset</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // script preview image
            function previewImage() {
                const image = document.querySelector('#foto');
                const impPreview = document.querySelector('.img-preview');

                impPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    impPreview.src = oFREvent.target.result;
                }
            }
        </script>
        @endsection
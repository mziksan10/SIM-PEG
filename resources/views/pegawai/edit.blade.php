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
        <!-- belum ada -->
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
                <div class="card-body">
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-8 d-flex justify-content-start">
                                    <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-user"></i> Detail Pribadi</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updatePegawai', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-row">
                                    <div class="col-xl-2 col-md-6">
                                        <div class="img-thumbnail modal-dialog-centered justify-content-center bg-light mb-3">
                                            <div style="max-height: 500px; max-width: 250px; overflow: hidden;">
                                                @if($pegawai->foto)
                                                <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-preview mb-2" style="height: 300px; width: 250px; overflow: hidden;">
                                                @elseif(!$pegawai->foto)
                                                <img src="{{ asset('assets/img') }}/user_default.png" class="img-preview mb-2" style="height: 300px; width: 250px; overflow: hidden;">
                                                @else
                                                <img class="img-preview mb-2" style="height: 300px; width: 250px; overflow: hidden;">
                                                @endif
                                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" onchange="previewImage()">
                                            </div>
                                        </div>
                                        @error('foto')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>NIP</label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $pegawai->nip) }}" disabled>
                                        @error('nip')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>NIK</label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik', $pegawai->nik) }}">
                                        @error('nik')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $pegawai->nama) }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                        @error('nama')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Tempat Lahir</label>
                                        <select name="tempat_lahir" class="select2 form-control @error('tempat_lahir') is-invalid @enderror">
                                            <option value="" selected>Pilih..</option>
                                            @foreach($data_cities as $item)
                                            @if(old('tempat_lahir', $pegawai->tempatLahir->city_id) == $item->city_id)
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
                                    <div class="form-group col-md-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                            @foreach($jenisKelamin as $item)
                                            @if(old('jenis_kelamin', $pegawai->jenis_kelamin) == $item)
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
                                    <div class="form-group col-md-2">
                                        <label>Status Pernikahan</label>
                                        <select name="status_pernikahan" class="form-control @error('status_pernikahan') is-invalid @enderror">
                                            @foreach($statusPernikahan as $item)
                                            @if(old('status_pernikahan', $pegawai->status_pernikahan) == $item)
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
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6 col-md-8">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat', $pegawai->alamat) }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                        @error('alamat')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-2 col-md-4">
                                        <label>Status Kepemilikan Rumah (Alamat)</label>
                                        <select id="status_kepemilikan_rumah" name="status_kepemilikan_rumah" class="form-control @error('status_kepemilikan_rumah') is-invalid @enderror">
                                            @foreach($statusKepemilikanRumah as $item)
                                            @if(old('status_kepemilikan_rumah', $pegawai->status_kepemilikan_rumah) == $item)
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
                                    <div class="form-group col-md-4">
                                        <label>Provinsi</label>
                                        <select id="provinsi" name="provinsi" class="select2 form-control @error('provinsi') is-invalid @enderror">
                                            @foreach($data_provinces as $item)
                                            @if(old('provinsi', $pegawai->provinces->prov_id) == $item->prov_id)
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
                                    <div class="form-group col-md-4">
                                        <label>Kabupaten/Kota</label>
                                        <select id="kab_kota" name="kab_kota" class="select2 form-control @error('kab_kota') is-invalid @enderror">
                                            <option value="{{ $pegawai->kab_kota }}" selected>{{ $pegawai->cities->city_name }}</option>
                                        </select>
                                        @error('kab_kota')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                                            <option value="{{ $pegawai->kecamatan }}" selected>{{ $pegawai->districts->dis_name }}</option>
                                        </select>
                                        @error('kecamatan')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Desa</label>
                                        <select id="desa" name="desa" class="select2 form-control @error('desa') is-invalid @enderror">
                                            <option value="{{ $pegawai->desa }}" selected>{{ $pegawai->subdistricts->subdis_name }}</option>
                                        </select>
                                        @error('desa')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos', $pegawai->kode_pos) }}">
                                        @error('kode_pos')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>No. HP</label>
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}">
                                        @error('no_hp')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $pegawai->email) }}" style="text-transform:lower">
                                        @error('email')
                                        <div class=" invalid-feedback ml-3">{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk) }}">
                                        @error('tanggal_masuk')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($pegawai->status == 2)
                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            @foreach($status as $item)
                                            @if(old('status', $pegawai->status) == $item)
                                            <option value="{{ $item }}" selected>@if($item == 1) Tetap @elseif($item == 2) Kontrak @elseif($item == 0) Non Aktif @endif</option>
                                            @else
                                            <option value="{{ $item }}">@if($item == 1) Tetap @elseif($item == 2) Kontrak @elseif($item == 0) Non Aktif @endif</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback ml-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @else
                                    <input type="hidden" name="status" value="{{$pegawai->status}}">
                                    @endif
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
                                    <input type="text" class="form-control @error('instansi_sebelumnya') is-invalid @enderror" name="instansi_sebelumnya" value="{{ old('instansi_sebelumnya', $pegawai->instansi_sebelumnya) }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('instansi_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control @error('pekerjaan_sebelumnya') is-invalid @enderror" name="pekerjaan_sebelumnya" value="{{ old('pekerjaan_sebelumnya', $pegawai->pekerjaan_sebelumnya) }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('pekerjaan_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-3 col-md-4">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control @error('jabatan_sebelumnya') is-invalid @enderror" name="jabatan_sebelumnya" value="{{ old('jabatan_sebelumnya', $pegawai->jabatan_sebelumnya) }}" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()">
                                    @error('jabatan_sebelumnya')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-2 col-md-2">
                                    <label>Masa Jabatan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('masa_jabatan_sebelumnya') is-invalid @enderror" name="masa_jabatan_sebelumnya" value="{{ old('masa_jabatan_sebelumnya', $pegawai->masa_jabatan_sebelumnya) }}">
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
                    <button type="submit" class="btn btn-primary float-right col-md-3"><i class="fas fa-save fa-sm"></i> Save</button>
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
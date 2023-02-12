@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
        <div class="card-header">
                <center>
                FORMULIR UBAH DATA PEGAWAI <br>
                POLITEKNIK PIKSI GANESHA
                </center>
            </div>
            <div class="card-body">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    <b>Perhatian</b>
                    <ul>
                        <li>Untuk menambahkan data pegawai lama gunakan fitur import pegawai.</li>
                        <li>NIP sudah di generate secara otomatis oleh sistem.</li>
                        <li>Ukuran foto tidak boleh lebih dari 1 MB.</li>
                        <li>Penulisan nama gelar harus benar.</li>
                    </ul>
                </small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="col-lg-8">
                    <form action="/pegawai/{{ $pegawai->id }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-row">
                            @if($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-preview img-fluid mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                            @elseif(!$pegawai->foto)
                            <img src="{{ asset('assets/img') }}/user_default.png" class="img-preview img-thumbnail rounded-circle mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                            @else
                            <img class="img-preview img-fluid mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>PAS Foto</label>
                                <input type="hidden" name="foto_lama" value="{{$pegawai->foto}}">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" autofocus onchange="previewImage()">
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
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $pegawai->nama) }}">
                            @error('nama')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-7">
                                <label>Tempat Lahir</label>
                                <select name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                    @foreach($data_cities as $item)
                                    @if(old('tempat_lahir', ucwords(strtoupper($pegawai->tempat_lahir))) == $item->city_name)
                                    <option value="{{ $item->city_name }}" selected>{{ $item->city_name }}</option>
                                    @else
                                    <option value="{{ $item->city_name }}">{{ $item->city_name }}</option>
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
                                    @foreach($jenis_kelamin as $item)
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
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('alamat', $pegawai->alamat) }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <label>Provinsi</label>
                                <select id="provinsi" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror">
                                    @foreach($data_provinces as $item)
                                    @if(old('provinsi', ucwords(strtoupper($pegawai->provinsi))) == $item->prov_name)
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
                                <select id="kab_kota" name="kab_kota" class="form-control @error('kab_kota') is-invalid @enderror">
                                    <option value="{{ $pegawai->kab_kota }}" selected>{{ ucwords(strtoupper($pegawai->kab_kota)) }}</option>
                                </select>
                                @error('kab_kota')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                                    <option value="{{ $pegawai->kecamatan }}" selected>{{ ucwords(strtoupper($pegawai->kecamatan)) }}</option>
                                </select>
                                @error('kecamatan')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Desa</label>
                                <select id="desa" name="desa" class="form-control @error('desa') is-invalid @enderror">
                                    <option value="{{ $pegawai->desa }}" selected>{{ ucwords(strtoupper($pegawai->desa)) }}</option>
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
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $pegawai->email) }}"">
                                @error('email')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk) }}">
                                @error('tanggal_masuk')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($pegawai->status == 2)
                            <div class="form-group col-3">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    @foreach($status as $item)
                                    @if(old('status', $pegawai->status) == $item)
                                    <option value="{{ $item }}" selected>@if($item == 1) Tetap @elseif($item == 2) Kontrak @endif</option>
                                    @else
                                    <option value="{{ $item }}">@if($item == 1) Tetap @elseif($item == 2) Kontrak @endif</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </form>
                </div>
            </div>
        </div>
        </div>
</div>

<script>

    // script preview image
    function previewImage(){
        const image = document.querySelector('#foto');
        const impPreview = document.querySelector('.img-preview');

        impPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            impPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection
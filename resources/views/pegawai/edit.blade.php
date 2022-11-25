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
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir {{ $title }}</h6>
            </div>
            <div class="card-body">
                <div class="col-lg-8">
                    <form action="/pegawai/{{ $pegawai->id }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-row">
                            @if($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-preview img-fluid mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                            @else
                            <img class="img-preview img-fluid mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>PAS Foto</label>
                                <input type="hidden" name="foto_lama" value="{{$pegawai->foto}}">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" autofocus onchange="previewImage()">
                                <small class="form-text text-muted ml-2"><i>*ukuran foto tidak boleh lebih dari 3 MB.</i></small>
                                @error('foto')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label>NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $pegawai->nip) }}">
                                @error('nip')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                              </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $pegawai->nama) }}">
                            <small class="form-text text-muted ml-2"><i>*lengkapi dengan gelar jika ada.</i></small>
                            @error('nama')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}"">
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
                            <div class="form-group col-md-7">
                                <label>Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat', $pegawai->alamat) }}"">
                                @error('alamat')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label>Desa</label>
                                <input type="text" class="form-control @error('desa') is-invalid @enderror" name="desa" value="{{ old('desa', $pegawai->desa) }}">
                                @error('desa')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" value="{{ old('kecamatan', $pegawai->kecamatan) }}">
                                @error('kecamatan')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control @error('kab_kota') is-invalid @enderror" name="kab_kota" value="{{ old('kab_kota', $pegawai->kab_kota) }}">
                                @error('kab_kota')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Provinsi</label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" value="{{ old('provinsi', $pegawai->provinsi) }}">
                                @error('provinsi')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos', $pegawai->kode_pos) }}">
                                @error('kode_pos')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>No. HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}">
                                @error('no_hp')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-7">
                                <label>Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $pegawai->email) }}"">
                                @error('email')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Pendidikan Terakhir</label>
                                <select name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                    @foreach($pendidikan as $item)
                                    @if(old('pendidikan', $pegawai->pendidikan ) == $item)
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
                            <div class="form-group col-md-9">
                                <label>Jurusan</label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan', $pegawai->jurusan) }}">
                                @error('jurusan')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>No. Rekening</label>
                                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" name="no_rekening" value="{{ old('no_rekening', $pegawai->no_rekening) }}">
                                @error('no_rekening')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label>BANK</label>
                                <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ old('bank', $pegawai->bank) }}">
                                @error('bank')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk) }}">
                                @error('tanggal_masuk')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    @foreach($status as $item)
                                    @if(old('status', $pegawai->status ) == $item)
                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                    @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
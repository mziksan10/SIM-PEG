@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="form-col">
        <form action="{{ route('import-pegawai') }}" method="POST" enctype="multipart/form-data">
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
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <center>
                FORMULIR PENDAFTARAN PEGAWAI <br>
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
                    <form action="/pegawai" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status" value="@if(!old('status')) {{ $status }} @else {{ old('status') }} @endif" readonly="readonly">
                        <div class="form-row">
                            <img class="img-preview img-thumbnail rounded-circle mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>PAS Foto</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" onchange="previewImage()">
                            @error('foto')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="@if(!old('nip')) {{ $nip_baru }} @else {{ old('nip') }} @endif" readonly="readonly">
                            @error('nip')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <label>NIK</label>
                                <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" autofocus>
                                @error('nik')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}">
                            @error('nama')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Tempat Lahir</label>
                                <select name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                    @foreach($data_cities as $item)
                                    @if(old('tempat_lahir') == $item->city_id)
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
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                    @foreach($jenis_kelamin as $item)
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
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <label>Provinsi</label>
                                <select id="provinsi" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                    @foreach($data_provinces as $item)
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
                            <div class="form-group col-md-4">
                                <label>Kabupaten/Kota</label>
                                <select id="kab_kota" name="kab_kota" class="form-control @error('kab_kota') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
                                </select>
                                @error('kab_kota')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                                    <option value="" selected>Pilih..</option>
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
                                    <option value="" selected>Pilih..</option>
                                </select>
                                @error('desa')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos') }}"">
                                @error('kode_pos')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>No. HP</label>
                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}"">
                                @error('no_hp')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"">
                                @error('email')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                </div>
            </div>
        </div>
        </div>
</div>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: 'Pilih..',
        ajax: {
            url: '/ajax_autocomplete',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.golongan.concat(' - ').concat(item.status),
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script> --}}

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script>
    var path = "{{ url('/autocomplete') }}";
    
    $('#golongan_id').typeahead({
        source: function(query, process){
            return $.get(path, {query:query}, function(data){
                return process(data);
            });
        }
    });
</script> --}}

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
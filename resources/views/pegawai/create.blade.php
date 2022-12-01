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
                    <form action="/pegawai" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <img class="img-preview img-fluid mb-2" style="max-height: 227px; max-width: 151px; overflow: hidden;">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>PAS Foto</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" autofocus onchange="previewImage()">
                                <small class="form-text text-muted ml-2"><i>*ukuran foto tidak boleh lebih dari 3 MB.</i></small>
                                @error('foto')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                                <label>NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group col-md-6">
                                <label>NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}">
                                @error('nik')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                        </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}">
                            <small class="form-text text-muted ml-2"><i>*lengkapi dengan gelar jika ada.</i></small>
                            @error('nama')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir') }}"">
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
                            <div class="form-group col-md-7">
                                <label>Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}"">
                                @error('alamat')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label>Desa</label>
                                <input type="text" class="form-control @error('desa') is-invalid @enderror" name="desa" value="{{ old('desa') }}"">
                                @error('desa')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" value="{{ old('kecamatan') }}"">
                                @error('kecamatan')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control @error('kab_kota') is-invalid @enderror" name="kab_kota" value="{{ old('kab_kota') }}"">
                                @error('kab_kota')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Provinsi</label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" value="{{ old('provinsi') }}"">
                                @error('provinsi')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ old('kode_pos') }}"">
                                @error('kode_pos')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>No. HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}"">
                                @error('no_hp')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-7">
                                <label>Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"">
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
                                    @if(old('pendidikan') == $item)
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
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan') }}">
                                @error('jurusan')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>No. Rekening</label>
                                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" name="no_rekening" value="{{ old('no_rekening') }}">
                                @error('no_rekening')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label>BANK</label>
                                <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ old('bank') }}">
                                @error('bank')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                                @error('tanggal_masuk')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
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
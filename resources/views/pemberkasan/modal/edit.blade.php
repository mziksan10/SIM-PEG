@foreach($data_berkas as $item)
@if($item->pegawai === null)
@elseif($item->pegawai)
<form action="/riwayat-pemberkasan/{{ $item->id }}" method="POST" enctype="multipart/form-data">
@method('put')
@csrf

    <div class="modal fade" tabindex="-1" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit {{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="form-row">
        <div class="form-group col-md-12">
            <label>NIP</label>
            <input type="search" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $item->pegawai->nip ) }}">
            @error('nip')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        </div>
        <div class="form-row">
        <div class="col-12">
        <label>Upload Berkas</label>
        <div class="input-group mb-3">
            <input type="hidden" name="file_lama" value="{{ $item->file }}">
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
            @error('file')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
            </div>
        </div>
        </div>
        <div class="form-row">
        <div class="col-12">
            <label>Jenis Berkas</label>
             <div class="input-group mb-3">
                <select name="jenis_berkas" class="form-control @error('jenis_berkas') is-invalid @enderror" autofocus>
                    <option value="" selected>--Pilih--</option>
                    @foreach($jenis_berkas as $jb)
                    @if(old('jenis_berkas', $item->jenis_berkas) == $jb)
                    <option value="{{ $jb }}" selected>{{ $jb }}</option>
                    @else
                    <option value="{{ $jb }}">{{ $jb }}</option>
                    @endif
                    @endforeach
                </select>
                @error('jenis_berkas')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        </div>
        <div class="form-row">
        <div class="form-group col-12">
            <label>Keterangan</label>
             <div class="input-group">
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}">
            </div>
            @error('keterangan')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        </div>
        <div class="form-row">
            <div class="col-12">
            <button type="submit" class="btn btn-primary" style="width:100%">Save</button>
            </div>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

</form>
@endif
@endforeach
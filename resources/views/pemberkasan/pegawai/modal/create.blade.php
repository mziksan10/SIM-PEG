<form action="/berkas" method="POST" enctype="multipart/form-data">
@csrf

    <div class="modal fade" tabindex="-1" id="createModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Input</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <input type="hidden" name="pegawai_id" value="{{ session()->get('pegawai_id') }}">
        <div class="form-row">
        <div class="col-12">
        <label>Upload Berkas</label>
        <div class="input-group mb-3">
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
                    @foreach($jenis_berkas as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('jenis_berkas')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        </div>
        <div class="form-row">
        <div class="col-12">
            <label>Keterangan</label>
             <div class="input-group">
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">
            </div>
            @error('keterangan')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </div>
    </div>

</form>
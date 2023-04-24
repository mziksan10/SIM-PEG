<form action="{{ route('storeBerkas') }}" method="POST" enctype="multipart/form-data">
@csrf

    <div class="modal fade" tabindex="-1" id="createModalBerkas">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Input Berkas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <input type="hidden" name="nip" value="{{ $pegawai->nip }}">
        <div class="form-row">
            <div class="form-group col-md-6">
            <label>Jenis Berkas</label>
            <select name="jenis_berkas" class="form-control @error('jenis_berkas') is-invalid @enderror" autofocus>
                <option value="" selected>Pilih..</option>
                @foreach($jenisBerkas as $item)
                <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
            @error('jenis_berkas')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group col-md-6">
            <label>Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan" name="keterangan">
            @error('keterangan')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
            </div>
        </div> 
        <div class="form-row">
        <div class="form-group col-md-12">
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
            @error('file')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
            </div>
        </div> 
        <div class="form-row">
        <div class="col-lg-6 col-md-6">
        <button type="submit" class="btn btn-primary" style="width:100%"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
        <div class="col-lg-6 col-md-6">
        <button type="reset" class="btn btn-secondary" style="width:100%"><i class="fas fa-redo"></i> Reset</button>
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
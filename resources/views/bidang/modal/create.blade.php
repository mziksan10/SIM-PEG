<form action="/bidang" method="POST">
@csrf

<div class="modal fade" tabindex="-1" id="createModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Form Input {{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div class="form-row">
        <div class="form-group col-md-3">
            <label>Kode Bidang</label>
            <input type="text" class="form-control @error('kode_bidang') is-invalid @enderror" name="kode_bidang" value="{{ old('kode_bidang') }}">
            @error('kode_bidang')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-9">
            <label>Nama Bidang</label>
            <input type="text" class="form-control @error('nama_bidang') is-invalid @enderror" name="nama_bidang" value="{{ old('nama_bidang') }}">
            @error('nama_bidang')
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
@foreach($data_jabatan as $item)   
<form action="/jabatan/{{ $item->id }}" method="POST">
@method('put')
@csrf

<div class="modal fade" tabindex="-1" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Kode Jabatan</label>
                <input type="text" class="form-control @error('kode_jabatan') is-invalid @enderror" name="kode_jabatan" value="{{ old('kode_jabatan', $item->kode_jabatan) }}">
                @error('kode_jabatan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-9">
                <label>Nama Jabatan</label>
                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" name="nama_jabatan" value="{{ old('nama_jabatan', $item->nama_jabatan) }}">
                @error('nama_jabatan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
    </div>
    </div>

</form>
@endforeach
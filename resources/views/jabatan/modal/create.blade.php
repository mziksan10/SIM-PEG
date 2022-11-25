<form action="/jabatan" method="POST">
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

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Kode Jabatan</label>
                <input type="text" class="form-control @error('kode_jabatan') is-invalid @enderror" name="kode_jabatan" value="{{ old('kode_jabatan') }}">
                @error('kode_jabatan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-9">
                <label>Nama Jabatan</label>
                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" name="nama_jabatan" value="{{ old('nama_jabatan') }}">
                @error('nama_jabatan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Bidang</label>
                <select name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($data_bidang as $item)
                    @if(old('bidang_id') == $item->id)
                    <option value="{{ $item->id }}"  selected>{{ $item->nama_bidang }}</option>
                    @else
                    <option value="{{ $item->id }}">{{ $item->nama_bidang }}</option>
                    @endif
                    @endforeach
                </select>
                @error('bidang_id')
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
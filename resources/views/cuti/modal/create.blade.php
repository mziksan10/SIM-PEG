<form action="/cuti" method="POST">
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
        <div class="form-group col-md-6">
            <label>NIP</label>
            <input type="search" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}">
            @error('nip')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-9">
                <label>Jenis Cuti</label>
                <select name="jenis_cuti" class="form-control @error('jenis_cuti') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($jenis_cuti as $item)
                    @if(old('jenis_cuti') == $item)
                    <option value="{{ $item }}" selected>{{ $item }}</option>
                    @else
                    <option value="{{ $item }}">{{ $item }}</option>
                    @endif
                    @endforeach
                </select>
                @error('nama_bidang')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Tanggal Cuti</label>
                <input type="date" class="form-control @error('tanggal_cuti') is-invalid @enderror" name="tanggal_cuti" value="{{ old('tanggal_cuti') }}">
                @error('tanggal_cuti')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Tanggal Masuk</label>
                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                @error('tanggal_masuk')
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
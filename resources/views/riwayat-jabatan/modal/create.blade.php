<form action="/riwayat-jabatan" method="POST">
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
            <div class="form-group col-md-6">
                <label>No. SK</label>
                <input type="text" id="no_sk" class="form-control @error('no_sk') is-invalid @enderror" name="no_sk" value="{{ old('no_sk') }}">
                @error('no_sk')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Tanggal SK</label>
                <input type="date" id="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                @error('tanggal_sk')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Bidang</label>
                <select id="bidang_id" name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror">
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
            <div class="form-group col-md-6">
                <label>Jabatan</label>
                <select id="jabatan_id" name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                </select>
                @error('jabatan_id')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Golongan</label>
                {{-- <input type="text" class="form-control typeahead @error('golongan_id') is-invalid @enderror" name="golongan_id" id="golongan_id" value="{{ old('golongan_id') }}" autocomplete="off"> --}}
                {{-- <select name="golongan_id" class="livesearch form-control @error('golongan_id') is-invalid @enderror"></select> --}}
                <select name="golongan_id" class="form-control @error('golongan_id') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($data_golongan as $item)
                    @if(old('golongan_id') == $item->id)
                    @if($item->status == 'Kontrak')
                    <option value="{{ $item->id }}"  selected>{{ $item->golongan . ' - ' . 'Kontrak' }}</option>
                    @elseif($item->status == 'Tetap')
                    <option value="{{ $item->id }}"  selected>{{ $item->golongan . ' - ' . 'Tetap' }}</option>
                    @endif
                    @else
                    @if($item->status == 'Kontrak')
                    <option value="{{ $item->id }}">{{ $item->golongan . ' - ' . 'Kontrak' }}</option>
                    @elseif($item->status == 'Tetap')
                    <option value="{{ $item->id }}">{{ $item->golongan . ' - ' . 'Tetap' }}</option>
                    @endif
                    @endif
                    @endforeach
                </select>
                @error('golongan_id')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">

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
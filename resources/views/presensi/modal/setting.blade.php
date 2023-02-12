    <div class="modal fade" tabindex="-1" id="createModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Setting</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        @foreach($aturan_presensi as $item)
        <div class="col">
        <form action="/ubah_presensi/{{ $item->id }}" method="POST">
        @method('put')
        @csrf
        <input type="hidden" name="id" value="{{ $item->id }}">
        <div class="form-group">
            <div class="row mb-3">
                <div class="col-2">
                <label>Sesi</label>
                <input class="form-control @error('sesi') is-invalid @enderror" name="sesi" value="{{ old('sesi', $item->sesi) }}" disabled>
                @error('sesi')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-6">
                <label>Jam Masuk</label>
                <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" name="jam_masuk" value="{{ old('jam_masuk', $item->jam_masuk) }}">
                @error('jam_masuk')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                <label>Batas Minimal</label>
                <input type="time" class="form-control @error('batas_min') is-invalid @enderror" name="batas_min" value="{{ old('batas_min', $item->batas_min) }}">
                @error('batas_min')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-6">
                <label>Batas Maksimal</label>
                <input type="time" class="form-control @error('batas_max') is-invalid @enderror" name="batas_max" value="{{ old('batas_max', $item->batas_max) }}">
                @error('batas_max')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                <label>Late 1</label>
                <input type="time" class="form-control @error('late_1') is-invalid @enderror" name="late_1" value="{{ old('late_1', $item->late_1) }}">
                @error('late_1')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-6">
                <label>Late 2</label>
                <input type="time" class="form-control @error('late_2') is-invalid @enderror" name="late_2" value="{{ old('late_2', $item->late_2) }}">
                @error('late_2')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <button type="submit" class="btn btn-primary mb-3" style="width:100%">Save</button>
            </div>
        </div>
        </form>
        </div>
        @endforeach
        </div>
        </div>
    </div>
    </div>
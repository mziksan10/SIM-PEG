<form action="/riwayat-pendidikan" method="POST">
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
            <div class="form-group col-md-12">
                <label>NIP</label>
                <input type="search" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}">
                @error('nip')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tahun Lulus</label>
                <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" name="tahun_lulus" value="{{ old('tahun_lulus') }}">
                @error('tahun_lulus')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-8">
                <label>Jenjang</label>
                <select id="jenjang" name="jenjang" class="form-control @error('jenjang') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($pendidikan as $item)
                    @if(old('jenjang') == $item)
                    <option value="{{ $item }}"  selected>{{ $item }}</option>
                    @else
                    <option value="{{ $item }}">{{ $item }}</option>
                    @endif
                    @endforeach
                </select>
                @error('jenjang')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Jurusan</label>
                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan') }}">
                @error('jurusan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nama Institusi</label>
                <input type="text" class="form-control @error('institusi') is-invalid @enderror" name="institusi" value="{{ old('institusi') }}">
                @error('institusi')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>  

        <div class="form-row">
        <div class="col">
        <button type="submit" class="btn btn-primary mt-3" style="width:100%">Submit</button>
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
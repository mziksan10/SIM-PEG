@foreach($data_riwayatPendidikan as $item)
    @if($item->pegawai === null)
    @elseif($item->pegawai)
<form action="/riwayat-pendidikan" method="POST">
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
                <input type="search" id="nip" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $item->pegawai->nip) }}">
                @error('nip')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tahun Lulus</label>
                <input type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" name="tahun_lulus" value="{{ old('tahun_lulus', $item->tahun_lulus) }}">
                @error('tahun_lulus')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-8">
                <label>Jenjang</label>
                <select id="jenjang" name="jenjang" class="form-control @error('jenjang') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($pendidikan as $p)
                    @if(old('jenjang', $item->jenjang) == $p)
                    <option value="{{ $p }}"  selected>{{ $p }}</option>
                    @else
                    <option value="{{ $p }}">{{ $p }}</option>
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
                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan', $item->jurusan) }}">
                @error('jurusan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nama Institusi</label>
                <input type="text" class="form-control @error('institusi') is-invalid @enderror" name="institusi" value="{{ old('institusi', $item->tahun_lulus) }}">
                @error('institusi')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>  

        <div class="form-row">
        <div class="col">
        <button type="submit" class="btn btn-primary mt-3" style="width:100%">Save</button>
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
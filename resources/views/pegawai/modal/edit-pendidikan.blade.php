@if($pegawai->riwayatPendidikan)
<form action="{{ route('updateRiwayatPendidikan', $pegawai->riwayatPendidikan->id) }}" method="POST" enctype="multipart/form-data">
@method('put')
@csrf
<div class="modal fade" tabindex="-1" id="editModalPendidikan{{ $pegawai->riwayatPendidikan->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Detail Pendidikan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <input type="hidden" name="nip" value="{{ $pegawai->nip }}">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tahun Lulus</label>
                <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" name="tahun_lulus" value="{{ old('tahun_lulus', $pegawai->riwayatPendidikan->tahun_lulus) }}">
                @error('tahun_lulus')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-8">
                <label>Jenjang</label>
                <select id="jenjang" name="jenjang" class="form-control @error('jenjang') is-invalid @enderror">
                    <option value="" selected>Pilih..</option>
                    @foreach($jenjang as $item)
                    @if(old('jenjang', $pegawai->riwayatPendidikan->jenjang) == $item)
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
                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" value="{{ old('jurusan', $pegawai->riwayatPendidikan->jurusan) }}">
                @error('jurusan')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nama Institusi</label>
                <input type="text" class="form-control @error('institusi') is-invalid @enderror" name="institusi" value="{{ old('institusi', $pegawai->riwayatPendidikan->institusi) }}">
                @error('institusi')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div> 
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Upload Scan Ijazah</label>
                <input type="file" class="form-control @error('scan_ijazah') is-invalid @enderror" name="scan_ijazah">
                @error('scan_ijazah')
                <div class="invalid-feedback ml-3">{{ $message }}</div>
                @enderror
            </div>
        </div>  

        <div class="form-row">
        <div class="col">
        <button type="submit" class="btn btn-primary" style="width:100%">Save</button>
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
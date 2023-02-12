@foreach($data_riwayatPendidikan as $item)
    @if($item->pegawai === null)
    @elseif($item->pegawai)
    <div class="modal fade" tabindex="-1" id="showModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail {{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table">
            <tr>
                <th>NIP</th>
                <td> : </td>
                <td>{{ $item->pegawai->nip }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td> : </td>
                <td>{{ $item->pegawai->nama }}</td>
            </tr>
            <tr>
                <th>Jenjang</th>
                <td> : </td>
                <td>{{ $item->jenjang }}</td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td> : </td>
                <td>{{ $item->jurusan }}</td>
            </tr>
            <tr>
                <th>Nama Institusi</th>
                <td> : </td>
                <td>{{ $item->institusi }}</td>
            </tr>
            <tr>
                <th>Tahun Lulus</th>
                <td> : </td>
                <td>{{ $item->tahun_lulus }}</td>
            </tr>
            </table>
            <div class="row">
            <div class="col-12">
            <form action="/riwayat-pendidikan/{{ $item->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')" style="width:100%"><i class="fas fa-trash fa-sm"></i> Delete</button>
            </form>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    @endif
@endforeach
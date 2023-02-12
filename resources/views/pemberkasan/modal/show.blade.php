@foreach($data_berkas as $item)
    @if($item->pegawai === null)
    @elseif($item->pegawai)
    <div class="modal fade" tabindex="-1" id="showModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail</h5>
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
                <th>Bidang</th>
                <td> : </td>
                <td>{{ $item->jenis_berkas }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td> : </td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            <tr>
            <th>Berkas</th>
            <td> : </td>
            <td>
            <a href="{{asset('storage/' . $item->file)}}" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-pdf fa-sm"></i> PDF</a>
            </td>
            </tr>
            </table>
            <div class="row">
            <div class="col-12">
            <form action="/riwayat-pemberkasan/{{ $item->id }}" method="post" class="d-inline">
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
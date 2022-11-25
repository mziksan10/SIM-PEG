@foreach($data_riwayatjabatan as $item)    
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
                <th>Nama</th>
                <td> : </td>
                <td>{{ $item->pegawai->nama }}</td>
            </tr>
            <tr>
                <th>Bidang</th>
                <td> : </td>
                <td>{{ $item->bidang->nama_bidang }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td> : </td>
                <td>{{ $item->jabatan->nama_jabatan }}</td>
            </tr>
            <tr>
                <th>Golongan</th>
                <td> : </td>
                <td>
                    {{ $item->golongan->golongan . " - " }}
                    @if( $item->golongan->status == 'Kontrak')
                    <div class="badge badge-warning">Kontrak</div>
                    @elseif( $item->golongan->status == 'Tetap')
                    <div class="badge badge-primary">Tetap</div>
                    @endif
                </td>
            </tr>
            <tr>
                <th>No. SK</th>
                <td> : </td>
                <td>{{ $item->no_sk }}</td>
            </tr>
            <tr>
                <th>Tanggal SK</th>
                <td> : </td>
                <td>{{ $item->tanggal_sk }}</td>
            </tr>
            </table>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endforeach
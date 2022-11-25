@foreach($data_cuti as $item)    
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

            @if($item->pegawai->foto)
            <div style="max-height: 200px; max-width: 100px; overflow: hidden;">
            <img src="{{asset('storage/' . $item->pegawai->foto)}}" class="img-thumbnail ">
            </div>
            @else
            <div style="max-height: 200px; max-width: 100px; overflow: hidden;">
            <img src="{{asset('/assets/img/user_default.png')}}" class="img-thumbnail mb-3">
            </div>
            @endif
            <table class="table">
            <tr>
                <th>NIP</th>
                <td> : </td>
                <td>{{ $item->nip }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td> : </td>
                <td>{{ $item->pegawai->nama }}</td>
            </tr>
            <tr>
                <th>Jenis Cuti</th>
                <td> : </td>
                <td>{{ $item->jenis_cuti }}</td>
            </tr>
            <tr>
                <th>Tanggal Cuti</th>
                <td> : </td>
                <td>{{ $item->tanggal_cuti }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td> : </td>
                <td>{{ $item->tanggal_masuk }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td> : </td>
                <td>
                @if($item->tanggal_masuk == date('Y-m-d'))
                <div class="badge badge-warning">Selesai</div>
                @else
                <?php
                    $tgl_sekarang = new DateTime(date('Y-m-d'));
                    $tgl_masuk = new DateTime($item->tanggal_masuk);
                    $selisih = $tgl_sekarang->diff($tgl_masuk);
                ?>
                <div class="badge badge-light">Sisa : {{ $selisih->d }} Hari</div>
                @endif
                </td>
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
@foreach($data_aturanPresensi as $item)
<div class="modal fade" tabindex="-1" id="showModalAturan{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <table class="table">
            <tr>
                <th>Sesi</th>
                <td> : </td>
                <td>{{ $item->sesi }}</td>
            </tr>
            <tr>
                <th>Batas Minimal</th>
                <td> : </td>
                <td>{{ $item->batas_min }}</td>
            </tr>
            <tr>
                <th>Jam Masuk</th>
                <td> : </td>
                <td>{{ $item->jam_masuk }}</td>
            </tr>
            <tr>
                <th>Late 1</th>
                <td> : </td>
                <td>{{ $item->late_1 }}</td>
            </tr>
            <tr>
                <th>Late 2</th>
                <td> : </td>
                <td>{{ $item->late_2 }}</td>
            </tr>
            <tr>
                <th>Late 3</th>
                <td> : </td>
                <td>{{ $item->late_3 }}</td>
            </tr>
            <tr>
                <th>Batas Maksimal</th>
                <td> : </td>
                <td>{{ $item->batas_max }}</td>
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
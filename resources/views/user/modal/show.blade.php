@foreach($data_user as $item)   
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
                <th>Username</th>
                <td> : </td>
                <td>{{ $item->username }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td> : </td>
                <td>{{ $item->email }}</td>
            </tr>
            <tr>
                <th>Tanggal dibuat</th>
                <td> : </td>
                <td>{{ $item->created_at }}</td>
            </tr>
            <tr>
                <th>Tanggal diubah</th>
                <td> : </td>
                <td>{{ $item->updated_at }}</td>
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
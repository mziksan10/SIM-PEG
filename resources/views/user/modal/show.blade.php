@foreach($data_user as $item)   
    <div class="modal fade" tabindex="-1" id="showModal{{ $item->id }}">
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
                <th>Role</th>
                <td> : </td>
                <td>{{ $item->role }}</td>
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
            @if($item->username != 'admin')
            <div class="row">
            <div class="col">
            <form action="/user/{{ $item->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')" style="width:100%"><i class="fas fa-trash fa-sm"></i> Delete</button>
            </form>
            </div>
            </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endforeach
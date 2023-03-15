@foreach($data_bidang as $item)   
<form action="/bidang/{{ $item->id }}" method="POST">
@method('put')
@csrf

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
                <th>Kode Bidang</th>
                <td> : </td>
                <td>{{ $item->kode_bidang }}</td>
            </tr>
            <tr>
                <th>Nama Bidang</th>
                <td> : </td>
                <td>{{ $item->nama_bidang }}</td>
            </tr>
        </table>
        <div class="row">
            <div class="col">
            <form action="/bidang/{{ $item->id }}" method="post" class="d-inline">
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

</form>
@endforeach
@foreach($data_golongan as $item)   
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
                <th>Golongan</th>
                <td> : </td>
                <td>{{ $item->golongan }}</td>
            </tr>
            <tr>
                <th>Jenjang</th>
                <td> : </td>
                <td>{{ $item->jenjang }}</td>
            </tr>
            <tr>
                <th>Masa kerja</th>
                <td> : </td>
                <td>@if($item->max_masa_kerja !== null) {{ $item->min_masa_kerja . ' - ' . $item->max_masa_kerja }} @else {{ $item->min_masa_kerja }} @endif Tahun</td>
            </tr>
            <tr>
                <th>Gaji pokok</th>
                <td> : </td>
                <td>Rp. {{ number_format($item->gaji_pokok, 2,',','.') }},-</td>
            </tr>            
            <tr>
                <th>Status</th>
                <td> : </td>
                <td>{{ $item->status }}</td>
            </tr>
            </table>
            <div class="row">
            <div class="col">
            <form action="/golongan/{{ $item->id }}" method="post" class="d-inline">
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
@endforeach
@foreach($data_user as $item)
<form action="/user/{{ $item->id }}" method="POST">
@method('put')
@csrf

    <div class="modal fade" tabindex="-1" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" name="username" value="{{ old('username', $item->username) }}">
            @error('username')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email', $item->email) }}">
            @error('email')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        <label>Role</label>
        <select name="role" class="form-control @error('role') is-invalid @enderror">
            <option value="">Pilih..</option>
            @foreach($role as $r)
            @if(old('role', $item->role ) == $r)
            <option value="{{ $r }}" selected>{{ $r }}</option>
            @else
            <option value="{{ $r }}">{{ $r }}</option>
            @endif
            @endforeach
        </select>
        @error('role')
        <div class="invalid-feedback ml-3">{{ $message }}</div>
        @enderror
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
    </div>
    </div>

</form>
@endforeach
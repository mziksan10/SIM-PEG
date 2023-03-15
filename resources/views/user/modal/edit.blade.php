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
            <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" name="username" value="{{ old('username', $item->username) }}" disabled>
            @error('username')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control @error('role') is-invalid @enderror">
            @foreach($roles as $role)
            @if(old('role', $item->role ) == $role)
            <option value="{{ $role }}" selected>{{ $role }}</option>
            @else
            <option value="{{ $role }}">{{ $role }}</option>
            @endif
            @endforeach
        </select>
        @error('role')
        <div class="invalid-feedback ml-3">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-group">
            <label>Password Baru    </label>
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password">
            @error('password')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Save</button>
        </div>
        </div>
    </div>
    </div>

</form>
@endforeach
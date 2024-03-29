<form action="/user" method="POST">
@csrf

    <div class="modal fade" tabindex="-1" id="createModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Form Input {{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div class="form-group">
            <label>NIP</label>
            <input type="search" id="nip" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
            @error('username')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
        <label>Role</label>
            <select name="role" class="form-control @error('role') is-invalid @enderror">
                <option value="">Pilih..</option>
                @foreach($roles as $role)
                @if(old('role') == $role)
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
            <label>Password</label>
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password">
            @error('password')
            <div class="invalid-feedback ml-3">{{ $message }}</div>
            @enderror
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </div>
    </div>

</form>
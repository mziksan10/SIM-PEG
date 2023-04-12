    <!-- Just an image -->
    <nav class="navbar navbar-light bg-dark">
    <div class="sidebar-brand-icon">
        <img src="{{ asset('/assets/img') }}/logo_piksi.png" alt="" class="img" width="40">
        <div class="btn-group btn-group-toggle ml-2">
        <label class="btn btn-secondary active">
            <input type="radio" name="options" checked><b><i>SIM</i></b>
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options"><b><i>PEG</i></b>
        </label>
        </div>
    </div>
    <div class="dropdown">
    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
    @if(session()->get('foto') == null)
    <img class="img-profile rounded-circle" src="{{asset('/assets/img/user_default.png')}}" width="20">
    {{ auth()->user()->username }}
    @elseif(session()->get('foto'))
    {{ auth()->user()->username }}
    <img class="img-profile rounded-circle" src="{{asset('storage/' . session()->get('foto'))}}" width="20">
    @endif
    </button>
    <div class="dropdown-menu dropdown-menu-right mt-3">
    <form action="/logout" method="POST">
        @csrf
        <button class="dropdown-item" type="submit">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </button>
    </form>
    </div>
    </div>
    </nav>
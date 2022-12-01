<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <div class="col">
        Home / <a href="#">{{ $title }}</a>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div style="padding:22px 0;"><span class="mr-2 d-none d-lg-inline text-gray-600 small">Tanggal : {{ date('d M Y') }}</span></div>
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(session()->get('nama') === null)
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucwords(auth()->user()->username) }}</span>
                <img class="img-profile rounded-circle" src="{{asset('/assets/img/user_default.png')}}">
                @elseif(session()->get('nama'))
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucwords(session()->get('nama')) }}</span>
                @if(session()->get('foto') === null)
                <img class="img-profile rounded-circle" src="{{asset('/assets/img/user_default.png')}}">
                @elseif(session()->get('foto'))
                <img class="img-profile rounded-circle" src="{{asset('storage/' . session()->get('foto'))}}">
                @endif
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>


    </ul>

</nav>
<!-- End of Topbar -->
@extends('auth/main')
@section('container')

<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-4 col-lg-6 col-md-9" style="position:absolute; top:50%; transform: translate(0, -50%);">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-6 d-none d-lg-block register-image"></div> -->
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat akun baru!</h1>
                            </div>
                            @if(session()->has('success'))                      
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <small>{{ session('success') }}</small>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @elseif(session()->has('failed'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <small>{{ session('failed') }}</small>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @else
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <small><b>Pendaaftaran akun</b> hanya bisa dilakukan jika sudah terdaftar sebagai pegawai di Politeknik Piksi Ganesha.</small>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form class="user" action="/register" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror"
                                        placeholder="Masukan NIP.." name="username" value="{{ old('username') }}">
                                    @error('username')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                        placeholder="Masukan Password.." name="password">
                                    @error('password')
                                    <div class="invalid-feedback ml-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">Register</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/login">Sudah punya akun? Masuk!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
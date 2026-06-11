@extends('src.pages.master')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Profil Pengguna</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->
        
        <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Update Profil Form -->
                    <div class="col-12 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Profil</h3>
                            </div>
                            <form action="{{ route('profile.update_profile') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @if(session('success_profile'))
                                        <div class="alert alert-success">
                                            {{ session('success_profile') }}
                                        </div>
                                    @endif
                                    
                                    @if($errors->has('name') || $errors->has('email'))
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->get('name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                                @foreach($errors->get('email') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update Password Form -->
                    <div class="col-12 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Ubah Password</h3>
                            </div>
                            <form action="{{ route('profile.update_password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @if(session('success_password'))
                                        <div class="alert alert-success">
                                            {{ session('success_password') }}
                                        </div>
                                    @endif

                                    @if($errors->has('current_password') || $errors->has('password'))
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->get('current_password') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                                @foreach($errors->get('password') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Saat Ini</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content-->
    </main>
@endsection

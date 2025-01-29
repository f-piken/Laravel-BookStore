@extends('layouts.app')

@section('title')
    Dashboard - Admin
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-start">
        <div class="col-lg-8">
            <h1>Selamat Datang, Admin</h1>
            <p>Gunakan panel ini untuk mengelola aplikasi Anda.</p>
            <div class="card shadow-sm rounded-lg">
                <div class="card-header text-center text-white" style="background-color: #B4D51E;">
                    <h5>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <!-- Tambahkan tombol navigasi untuk Profil dan Toko -->
                    <form action="{{ route('admin-dashboard.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <div class="row mb-3">
                            <div class="col-md-4">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="rounded-circle img-fluid" width="150" style="border: #B4D51E 2px solid;">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Foto Profil" class="rounded-circle img-fluid" width="150">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Profil</label>
                                    <input type="file" name="photo" class="form-control" id="photo">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
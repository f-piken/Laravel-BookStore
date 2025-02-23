@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Profil')
@section('page', 'Profil')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Editor</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('editors.index') }}" class="btn btn-outline-primary me-2">Profil</a>
                <a href="{{ route('editors.books', $editor->id) }}" class="btn btn-outline-secondary me-2">Buku</a>
            </div>
            <div class="card shadow-sm rounded-lg">
                <div class="card-header text-center text-white" style="background-color: #B4D51E;">
                    <h5>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <!-- Tambahkan tombol navigasi untuk Profil dan Toko -->
                    <form action="{{ route('editors.update', $editor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default_profile.jpg') }}" alt="Foto Profil" class="rounded-circle img-fluid" width="150" style="border: #B4D51E 2px solid;">
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
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $editor->phone) }}" placeholder="Silahkan isi nomor telepon anda">
                                </div>
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <input type="text" name="province" class="form-control" id="province" value="{{ old('province', $editor->province) }}" placeholder="Silahkan isi provinsi anda">
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Kota</label>
                                    <input type="text" name="city" class="form-control" id="city" value="{{ old('city', $editor->city) }}" placeholder="Silahkan isi kota anda">
                                </div>
                                <div class="mb-3">
                                    <label for="postal_code" class="form-label">Kode Pos</label>
                                    <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $editor->postal_code) }}" placeholder="Silahkan isi kode pos anda">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" id="address" rows="2" placeholder="Silahkan isi alamat lengkap anda">{{ old('address', $editor->address) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Profil</label>
                                    <input type="file" name="photo" class="form-control" id="photo">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="store_name" class="form-label">Nama Pena</label>
                                    <input type="text" name="store_name" class="form-control" id="store_name" value="{{ old('store_name', $editor->store_name) }}" placeholder="Silahkan isi nama pena anda">
                                </div>
                                <div class="mb-3">
                                    <label for="store_logo" class="form-label">Logo Penulis</label>
                                    <input type="file" name="store_logo" class="form-control" id="store_logo">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah logo toko.</small>
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

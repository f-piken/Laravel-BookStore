@extends('layouts.landing')

@section('title', 'Pesanan')
@section('page', 'Pesanan')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Seller</li>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('sellers.index') }}" class="btn btn-outline-secondary me-2">Profil</a>
        <a href="{{ route('sellers.toko') }}" class="btn btn-outline-secondary me-2">Toko</a>
        <a href="{{ route('sellers.pesanan') }}" class="btn btn-outline-primary">Pesanan</a>
    </div>
    <h1 class="mb-4">Daftar Pesanan</h1>
    @if ($pesan->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Belum ada pesanan yang dibuat.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($pesan as $order)
                <div class="col">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">#{{ $order->order_number }}</h5>
                            <hr>
                            <p class="mb-2">
                                <strong>Total:</strong> 
                                <span class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </p>
                            <p class="mb-2">
                                <strong>Status:</strong> 
                                <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : 'bg-success' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p class="mb-3">
                                <strong>Tanggal Pesan:</strong> 
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            <a href="{{ route('sellers.show', $order->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                        <div class="card-footer bg-light">
                            <small class="text-muted">Terakhir diperbarui: {{ $order->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection


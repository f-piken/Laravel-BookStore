@extends('layouts.landing')

@section('title', 'Pesanan')
@section('page', 'Pesanan')

@section('content')
<div class="container">
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
                                @php
                                    $badgeColors = [
                                        'pending' => 'bg-warning',
                                        'paid' => 'bg-info',
                                        'confirm' => 'bg-primary',
                                        'process' => 'bg-secondary',
                                        'done' => 'bg-success',
                                        'rated' => 'bg-dark',
                                    ];
                                    $badgeColor = $badgeColors[$order->status] ?? 'bg-light'; // Default jika status tidak dikenal
                                @endphp

                                <span class="badge {{ $badgeColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p class="mb-2">
                                <strong>Tanggal Pesan:</strong> 
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            @if ($order->status == 'done')
                            <p class="mb-3">
                                <span class="badge bg-warning">
                                    Butuh penilaian
                                </span>
                            </p> 
                            @endif
                            <a href="{{ route('customers.show', $order->id) }}" class="btn btn-primary btn-sm">
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


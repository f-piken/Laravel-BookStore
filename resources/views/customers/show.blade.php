@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Order Invoice')
@section('page', 'Order Invoice')

@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <section class="col-lg-12 col-md-12 shopping-cart">
                <div class="card mb-4 bg-light border-0 section-header">
                    <div class="card-body p-5">
                        <h2 class="mb-0">
                            Order Invoice 
                            @php
                                $badgeColors = [
                                    'pending' => 'bg-warning',
                                    'paid' => 'bg-info',
                                    'confirm' => 'bg-primary',
                                    'process' => 'bg-secondary',
                                    'done' => 'bg-success',
                                    'rated' => 'bg-dark',
                                ];
                                $badgeColor = $badgeColors[$pesan->status] ?? 'bg-light'; // Default jika status tidak dikenal
                            @endphp

                            <span class="badge {{ $badgeColor }}">
                                {{ ucfirst($pesan->status) }}
                            </span>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <!-- Address Section -->
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0"><i class="bx bx-map"></i> Delivery Address</h5>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-lg-6 col-12 mb-4">
                                    <address>
                                        <strong>{{ $customer->user->name }}</strong><br>
                                        {{ $customer->address }}<br>
                                        <abbr title="Phone">P: {{ $customer ->phone }}</abbr>
                                    </address>
                                    <span class="text-danger">Default address</span>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <!-- Optionally, show other addresses if available -->
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p>selected service:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item py-3 border-top fw-bold">
                                    <div class="row align-items-center">
                                        {{-- <div class="col-2 col-md-2 col-lg-2"></div> --}}
                                        <div class="col-4 col-md-4 col-lg-5">
                                            Service
                                        </div>
                                        <div class="col-3 col-md-2 col-lg-2">
                                            Estimate
                                        </div>
                                        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                            Cost
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-4 col-lg-5">
                                            {{ $pesan->option->name }}
                                        </div>
                                        <div class="col-3 col-md-2 col-lg-2">
                                            {{ $pesan->option->estimate }}
                                        </div>
                                        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                            <span class="fw-bold">IDR {{ number_format($pesan->option->cost, 2) }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <form action="{{ route('customers.confirm',$pesan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('customers.pesanan') }}" class="btn btn-second">Back</a>
                                    @if ($pesan->status == 'pending')
                                    <button type="submit" class="btn btn-first">Confirm Payment</button>
                                    @elseIf($pesan->status == 'process')
                                    <button type="submit" class="btn btn-first">Mark as Done</button>
                                    @elseIf($pesan->status == 'done')
                                    <a href="{{ route('customers.rate', $pesan->id) }}" class="btn btn-first">Rate</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="mb-5 card mt-6">
                            <div class="card-body p-6">
                                <h2 class="h5 mb-4">Order Details</h2>
                                <ul class="list-group list-group-flush">
                                    @foreach ($detail as $item)
                                        <li class="list-group-item py-3">
                                            <div class="row align-items-center">
                                                <div class="col-6 col-md-6 col-lg-7">
                                                    <div class="d-flex">
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" style="height: 50px;">
                                                        <div class="ms-3">
                                                            <a href="{{ route('product.show', $item->product->id) }}">
                                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                            </a>
                                                            <span>
                                                                <small class="text-muted">IDR {{ number_format($item->product->price, 2) }}</small>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3 col-md-2 col-lg-2">{{ $item->quantity }}</div>
                                                <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                    <span class="fw-bold">IDR {{ number_format($item->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Item Subtotal</div>
                                            <div class="fw-bold">IDR {{ number_format($pesan->subtotal, 2) }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Shipping Fee</div>
                                            <div class="fw-bold">IDR {{ number_format($pesan->option->cost, 2) }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Tax (11%)</div>
                                            <div class="fw-bold">IDR {{ number_format($pesan->tax, 2) }}</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 fw-bold">
                                            <div>Grand Total</div>
                                            <div>IDR {{ number_format($pesan->total_amount, 2) }}</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection

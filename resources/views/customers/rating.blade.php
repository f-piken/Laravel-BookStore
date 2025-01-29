@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Cart')
@section('page', 'Rating')

@section('sub')
<li class="breadcrumb-item active" aria-current="page">Orders</li>
@endsection

@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <section class="col-lg-12 col-md-12 shopping-cart">
                <div class="card mb-4 bg-light border-0 section-header">
                    <div class="card-body p-5">
                        <h2 class="mb-0">Product Rating</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-12 mx-auto"> <!-- Perbesar kolom untuk lebih lebar -->
                        <ul class="list-group list-group-flush">
                            <form action="{{ route('rate.multiple', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @foreach($cartItems as $item)
                                <li class="list-group-item py-4 border-top">
                                    <div class="row align-items-center">
                                        <!-- Product Image and Info -->
                                        <div class="col-lg-6 col-md-7">
                                            <div class="d-flex">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" style="height: 100px; width: 100px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        <h6 class="mb-1 mt-2">{{ $item->product->name }}</h6>
                                                    </a>
                                                    <span class="d-block text-muted small">IDR {{ number_format($item->product->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Rating -->
                                        <div class="mb-3">
                                            <label for="rating" class="form-label"></label>
                                            <select name="ratings[{{ $item->product->id }}]" class="form-select" required>
                                                <option value="" disabled selected>Select rating</option>
                                                <option value="1">1 Star</option>
                                                <option value="2">2 Stars</option>
                                                <option value="3">3 Stars</option>
                                                <option value="4">4 Stars</option>
                                                <option value="5">5 Stars</option>
                                            </select>
                                        </div>
                                        <!-- Quantity -->
                                        <div class="col-lg-2 col-md-2 text-center">
                                            <span class="fw-bold">Item : {{ $item->quantity }}</span>
                                        </div>
                                        <!-- Total Price -->
                                        <div class="text-end">
                                            <span class="fw-bold">Total : IDR {{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('home') }}" class="btn btn-second">Continue Shopping</a>
                                    <button type="submit" class="btn btn-first">Rate</button>
                                </div>
                            </form>                            
                        </ul>
                    </div>
                </div>                
            </section>
        </div>
    </div>
</section>

@endsection
@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Cart')
@section('page', 'Cart')

@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <section class="col-lg-12 col-md-12 shopping-cart">
                <div class="card mb-4 bg-light border-0 section-header">
                    <div class="card-body p-5">
                        <h2 class="mb-0">Shopping Cart</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        <ul class="list-group list-group-flush">
                            @foreach($cartItems as $item)
                            <li class="list-group-item py-3 border-top">
                                <div class="row align-items-center">
                                    <div class="col-6 col-md-6 col-lg-7">
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" style="height: 70px;">
                                            <div class="ms-3">
                                                <a href="{{ route('product.show', $item->product->id) }}">
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                </a>
                                                <span>
                                                    <small class="text-muted">IDR {{ number_format($item->product->price, 2) }}</small>
                                                </span>
                                                <div class="mt-2 small lh-1">
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-inherit">
                                                            <i class='bx bx-trash'></i> <span class="text-muted">Remove</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-2">
                                        <input type="number" name="qty" value="{{ $item->quantity }}" class="form-control" min="1" onchange="updateQuantity(this, {{ $item->id }})">
                                    </div>
                                    <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                        <span class="fw-bold">IDR {{ number_format($item->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-first">Continue Shopping</a>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 col-md-5">
                        <div class="mb-5 card mt-6">
                            <div class="card-body p-6">
                                <!-- heading -->
                                <h2 class="h5 mb-4">Summary</h2>
                                <div class="card mb-2">
                                    <!-- list group -->
                                    <ul class="list-group list-group-flush">
                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div>Item Subtotal</div>
                                            </div>
                                            <span>IDR {{ number_format($cartTotal, 2) }}</span>
                                        </li>

                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div>Service Fee</div>
                                            </div>
                                            <span>IDR 3.00</span>
                                        </li>

                                        <!-- list group item -->
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="me-auto">
                                                <div class="fw-bold">Subtotal</div>
                                            </div>
                                            <span class="fw-bold">IDR {{ number_format($cartTotal + 3.00, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-grid mb-1 mt-4">
                                    <!-- btn -->
                                    <a href="{{ route('orders.show') }}" class="btn btn-first btn-lg d-flex justify-content-between align-items-center">
                                        Go to Checkout
                                        <span class="fw-bold">IDR {{ number_format($cartTotal + 3.00, 2) }}</span>
                                    </a>
                                </div>
                                <!-- text -->
                                <p>
                                    <small>
                                        By placing your order, you agree to be bound by the Freshcart
                                        <a href="#!">Terms of Service</a>
                                        and
                                        <a href="#!">Privacy Policy.</a>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    function updateQuantity(input, cartItemId) {
        const quantity = input.value;

        // Send the new quantity to the server
        fetch(`/cart/update/${cartItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            // Update the total price for this item
            const totalPriceElement = input.closest('.list-group-item').querySelector('.fw-bold');
            totalPriceElement.innerText = `IDR ${data.totalPrice}`;
        });
    }
</script>
@endpush

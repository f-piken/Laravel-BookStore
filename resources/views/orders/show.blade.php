@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Check Out')
@section('page', 'Check Out')

@section('content')
<section class="main-content">
    <div class="container">
        <div class="row">
            <section class="col-lg-12 col-md-12 shopping-cart">
                <div class="card mb-4 bg-light border-0 section-header">
                    <div class="card-body p-5">
                        <h2 class="mb-0">Checkout</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <!-- Address Section -->
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0"><i class="bx bx-map"></i> Delivery Address</h5>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Add a new address</a>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="card card-body p-6">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="homeRadio" checked="">
                                            <label class="form-check-label text-dark" for="homeRadio">Home</label>
                                        </div>
                                        <address>
                                            <strong>{{ $customer->user->name }}</strong><br>
                                            {{ $customer->address }}<br>
                                            <abbr title="Phone">P: {{ $customer ->phone }}</abbr>
                                        </address>
                                        <span class="text-danger">Default address</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <!-- Optionally, show other addresses if available -->
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-0"><i class="bx bxs-truck"></i> Delivery Service</h5>
                        <div class="mt-3">
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{  $orderItems->first()->product->seller->id }}">
                                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                <input type="hidden" name="tax" value="{{ $tax }}">
                                <input type="hidden" name="total_amount" value="{{ $grandTotal }}">
                                <input type="hidden" name="cartItems" value="{{ json_encode($orderItems) }}">
                                <div class="mt-3">
                                    @foreach ($deliveryOptions as $key => $option)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="delivery_option" id="inlineRadio{{ $key }}" value="{{ $option->id }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio{{ $key }}">{{ $option->name }} </label>
                                        </div>
                                    @endforeach
                                </div>
                            
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('cart.index') }}" class="btn btn-second">Back to Shopping Cart</a>
                                    <button type="submit" class="btn btn-first">Place Order</button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-3">
                            <p>Available services:</p>
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
                                @foreach ($deliveryOptions as $key => $option)
                                    <li class="list-group-item py-3">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-4 col-lg-5">
                                                {{ $option['name'] }}
                                            </div>
                                            <div class="col-3 col-md-2 col-lg-2">
                                                {{ $option['estimate'] }}
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold">IDR {{ number_format($option['cost'], 2) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('cart.index') }}" class="btn btn-second">Back to Shopping Cart</a>
                            <a href="#!" class="btn btn-first">Place Order</a>
                        </div> --}}
                    </div>

                    <!-- Order Details -->
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="mb-5 card mt-6">
                            <div class="card-body p-6">
                                <h2 class="h5 mb-4">Order Details</h2>
                                <ul class="list-group list-group-flush">
                                    @foreach ($orderItems as $item)
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
                                                    <span class="fw-bold">IDR {{ number_format($item->total_price, 2) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Item Subtotal</div>
                                            <div class="fw-bold">IDR {{ number_format($subtotal, 2) }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Shipping Fee</div>
                                            <div class="fw-bold">IDR {{ number_format($shippingFee, 2) }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Tax (11%)</div>
                                            <div class="fw-bold">IDR {{ number_format($tax, 2) }}</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 fw-bold">
                                            <div>Grand Total</div>
                                            <div>IDR {{ number_format($grandTotal, 2) }}</div>
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

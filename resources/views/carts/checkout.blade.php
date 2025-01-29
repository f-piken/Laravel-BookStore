@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Top Rating')
@section('page', 'Top Rating')

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
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0"><i class='bx bx-map'></i> Delivery Address</h5>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Add a new address</a>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="card card-body p-6">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="homeRadio" checked="">
                                            <label class="form-check-label text-dark" for="homeRadio">Home</label>
                                        </div>
                                        <!-- address -->
                                        <address>
                                            <strong>Sugiarto</strong>
                                            <br>

                                            Grand Village Banguntapan Z1
                                            <br>

                                            Jl. Imogiri Timur 5, Bantul, Yogyakarta.
                                            <br>

                                            <abbr title="Phone">P: 0820-2310-2123</abbr>
                                        </address>
                                        <span class="text-danger">Default address</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="card card-body p-6">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="homeRadio">
                                            <label class="form-check-label text-dark" for="homeRadio">Office</label>
                                        </div>
                                        <!-- address -->
                                        <address>
                                            <strong>IndoKoding Office</strong>
                                            <br>

                                            Grand Village Banguntapan Z1
                                            <br>

                                            Jl. Imogiri Timur 5, Bantul, Yogyakarta.
                                            <br>

                                            <abbr title="Phone">P: 0820-2310-2123</abbr>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-0"><i class='bx bxs-truck'></i> Delivery Service</h5>
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="courier_code" id="inlineRadio1"
                                    value="jne">
                                <label class="form-check-label" for="inlineRadio1">JNE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="courier_code" id="inlineRadio2"
                                    value="pos">
                                <label class="form-check-label" for="inlineRadio2">POS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="courier_code" id="inlineRadio2"
                                    value="tiki">
                                <label class="form-check-label" for="inlineRadio2">TIKI</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p>Available services:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item py-3 border-top fw-bold">
                                    <div class="row align-items-center">
                                        <div class="col-2 col-md-2 col-lg-2"></div>
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
                                        <div class="col-2 col-md-2 col-lg-2">
                                            <input class="form-check-input" type="radio" name="delivery_package"
                                                id="inlineRadio2" value="oke">
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-5">
                                            OKE (Ongkos Kirim Ekonomis)
                                        </div>
                                        <div class="col-3 col-md-2 col-lg-2">
                                            4-5
                                        </div>
                                        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                            <span class="fw-bold">IDR 20.000</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3">
                                    <div class="row align-items-center">
                                        <div class="col-2 col-md-2 col-lg-2">
                                            <input class="form-check-input" type="radio" name="delivery_package"
                                                id="inlineRadio2" value="reguler">
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-5">
                                            REG (Layanan Reguler)
                                        </div>
                                        <div class="col-3 col-md-2 col-lg-2">
                                            2-3
                                        </div>
                                        <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                            <span class="fw-bold">IDR 30.000</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="#!" class="btn btn-second">Back to Shopping Cart</a>
                            <a href="#!" class="btn btn-first">Place Order</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="mb-5 card mt-6">
                            <div class="card-body p-6">
                                <!-- heading -->
                                <h2 class="h5 mb-4">Order Details</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item py-3 border-top">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-6 col-lg-7">
                                                <div class="d-flex">
                                                    <img src="assets/img/p1.jpg" alt="Ecommerce"
                                                        style="height: 50px;">
                                                    <div class="ms-3">
                                                        <a href="product.html">
                                                            <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                                        </a>
                                                        <span>
                                                            <small class="text-muted">IDR 200.000</small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-2 col-lg-2">
                                                1
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold">IDR 200.000</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-6 col-lg-7">
                                                <div class="d-flex">
                                                    <img src="assets/img/p2.jpg" alt="Ecommerce"
                                                        style="height: 50px;">
                                                    <div class="ms-3">
                                                        <a href="product.html">
                                                            <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                                        </a>
                                                        <span>
                                                            <small class="text-muted">IDR 200.000</small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-2 col-lg-2">
                                                1
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold">IDR 200.000</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-6 col-lg-7">
                                                <div class="d-flex">
                                                    <img src="assets/img/p3.jpg" alt="Ecommerce"
                                                        style="height: 50px;">
                                                    <div class="ms-3">
                                                        <a href="product.html">
                                                            <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-2 col-lg-2">
                                                1
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold">IDR 200.000</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Item Subtotal</div>
                                            <div class="fw-bold">IDR 500.000</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Shipping Fee</div>
                                            <div class="fw-bold">IDR 20.000</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>Tax (11%)</div>
                                            <div class="fw-bold">IDR 10.000</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 fw-bold">
                                            <div>Grand Total</div>
                                            <div>IDR 500.000</div>
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
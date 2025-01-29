<div class="row">
  @foreach ($mostSoldProducts as $product)
  <div class="col-lg-3 col-6">
    <div class="card card-product card-body p-lg-4 p3">
      <a href="{{ route('product.show', $product->id) }}">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
      </a>
      <h3 class="product-name mt-3">{{ $product->name }}</h3>
      <div class="rating">
        @for ($i = 1; $i <= 5; $i++)
          <i class="bx {{ $i <= $product->rate ? 'bxs-star' : 'bx-star' }}"></i>
        @endfor
      </div>
      <div class="detail d-flex justify-content-between align-items-center mt-4">
        <p class="price">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
        <a href="{{ route('product.show', $product->id) }}" class="btn-cart"><i class="bx bx-cart-alt"></i></a>
      </div>
    </div>
  </div>
  @endforeach
</div>
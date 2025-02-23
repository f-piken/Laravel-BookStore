<div class="row">
  @foreach ($book as $product)
  <div class="col-lg-3 col-6">
    <div class="card card-product card-body p-lg-4 p3">
      <a href="{{ route('book.show', $product->id) }}">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
      </a>
      <h3 class="mt-3">{{ $product->judul }}</h3>
      <div class="detail justify-content-between align-items-center mt-4">
        <p class="penulis">{{ $product->penulis }}</p>
        <p class="tahun">{{ $product->tahun_terbit }}</p>
      </div>
    </div>
  </div>
  @endforeach
</div>
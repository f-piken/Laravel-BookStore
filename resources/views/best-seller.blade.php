@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Best Seller')
@section('page', 'Best Seller')

@section('content')
  <!-- Popular -->
<section class="">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <h1>Best Seller</h1>
        </div>
      </div>
      @include('layouts.best')
    </div>
</section>
@endsection
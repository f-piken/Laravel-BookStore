@extends('layouts.landing') <!-- Gunakan layout yang sesuai, seperti 'app.blade.php' -->

@section('title', 'Top Rating')
@section('page', 'Top Rating')

@section('content')
<section class="">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-6">
        <h1>Top Rate</h1>
      </div>
    </div>
    @include('layouts.popular')
  </div>
</section>
@endsection
@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="card mt-4 table-container">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="color: white;">Daftar Pesanan</h5>
        <a class="btn btn-success btn-sm" href="{{ route('orders.report') }}">
            Report
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Pesanan</th>
                        <th>Seller</th>
                        <th>Customer</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->seller->user->name }}</td>
                            <td>{{ $order->customer->user->name }}</td>
                            <td>IDR {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            <td>IDR {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                {{-- <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Edit</a> --}}
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection

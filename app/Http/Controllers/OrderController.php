<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Traits\Count;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use Count;
    public function index()
    {
        $query = Order::with('seller.user', 'customer.user', 'deliveryOption');
    
        // Filter berdasarkan pencarian
        if ($search = request('q')) {
            $query->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('seller', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('deliveryOption', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
        }
    
        $orders = $query->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show()
    {
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();

        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        $deliveryOptions = DeliveryOption::all();

        $orderItems = Cart::where('customer_id', $customer->id)->get();

        $subtotal = $this->calculateSubtotal($orderItems);

        $shippingFee = $this->calculateShippingFee($deliveryOptions->first());

        $tax = $this->calculateTax($subtotal);

        $grandTotal = $this->calculateGrandTotal($subtotal, $shippingFee, $tax);

        return view('orders.show', compact(
            'customer',
            'deliveryOptions',
            'orderItems',
            'orderCount',
            'cartCount',
            'wishListCount',
            'subtotal',
            'shippingFee',
            'tax',
            'grandTotal'
        ));
    }

    // Menghitung subtotal item
    private function calculateSubtotal($orderItems)
    {
        $subtotal = 0;

        foreach ($orderItems as $item) {
            $subtotal += $item->total_price;
        }

        return $subtotal;
    }

    // Menghitung biaya pengiriman (contoh sederhana menggunakan biaya pengiriman pertama)
    private function calculateShippingFee($deliveryOption)
    {
        return $deliveryOption ? $deliveryOption->cost : 0;
    }

    // Menghitung pajak (misalnya 11% dari subtotal)
    private function calculateTax($subtotal)
    {
        return $subtotal * 0.11; // 11% pajak
    }

    // Menghitung grand total
    private function calculateGrandTotal($subtotal, $shippingFee, $tax)
    {
        return $subtotal + $shippingFee + $tax;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Validasi request
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'delivery_option' => 'required|exists:delivery_options,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'cartItems' => 'required|string',
        ]);
        $cartItems = json_decode($request->cartItems, true);
        if (!$cartItems) {
            return back()->withErrors(['cartItems' => 'Invalid cart items format'])->withInput();
        }
        // Ambil item keranjang belanja
        $orderItems = Cart::with('product.seller')->where('customer_id', $customer->id)->get();

        // Buat order_number secara acak
        $orderNumber = Str::random(10);

        // Simpan pesanan ke database
        $order = Order::create([
            'seller_id' => $request->seller_id,
            'customer_id' => $customer->id,
            'delivery_option_id' => $request->delivery_option,
            'order_number' => $orderNumber,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total_amount' => $request->total_amount,
            'status' => 'pending',
        ]);

        // Menambahkan produk ke order_items
        foreach ($cartItems as $cartItem) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['total_price'],
            ]);
        }

        // Hapus item dari keranjang setelah pesanan dibuat
        $orderItems->each->delete();
        // Redirect setelah berhasil membuat pesanan
        return redirect()->route('home')->with('success', 'Order created successfully.');
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function report()
    {
        // Ambil semua data orders
        $orders = Order::with(['seller.user', 'customer.user', 'deliveryOption'])->get();

        return view('orders.order', compact('orders'));
    }
    public function generatePDF()
    {
        // Ambil semua data orders
        $orders = Order::with(['seller.user', 'customer.user', 'deliveryOption'])->get();

        // Render ke PDF
        $pdf = Pdf::loadView('orders.report', compact('orders'));

        // Unduh file PDF
        return $pdf->download('orders-report.pdf');
    }
}

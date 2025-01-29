<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Traits\Count;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use Count;
    public function index()
    {
        $orderCount = $this->countOrdersBySeller();

        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Cari customer berdasarkan user_id
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return back()->with('error', 'Customer not found!');
        }
        // Mendapatkan semua item cart untuk user yang sedang login
        $cartItems = Cart::where('customer_id', $customer->id)->with('product')->get();

        // Menghitung total harga semua produk di keranjang
        $cartTotal = $cartItems->sum('total_price');

        return view('carts.index', compact('cartItems', 'orderCount','cartTotal','cartCount', 'wishListCount'));
    }

    public function remove($id)
    {
        // Menghapus item dari keranjang
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function update($id, Request $request)
    {
        // Mengupdate kuantitas item di keranjang
        $cartItem = Cart::findOrFail($id);
        $cartItem->quantity = $request->input('quantity');
        $cartItem->total_price = $cartItem->quantity * $cartItem->product->price;
        $cartItem->save();

        return response()->json([
            'totalPrice' => number_format($cartItem->total_price, 2),
        ]);
    }

    public function addToCart(Request $request, $productId)
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($productId);

        // Validasi kuantitas yang diminta
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');
        $totalPrice = $product->price * $quantity;

        // Cek apakah produk sudah ada di keranjang untuk customer ini
        $cartItem = Cart::where('customer_id', $customer->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // Jika produk sudah ada, perbarui kuantitas dan total harga
            $cartItem->quantity += $quantity;
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            // Jika produk belum ada di keranjang, buat entri baru
            Cart::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }
}

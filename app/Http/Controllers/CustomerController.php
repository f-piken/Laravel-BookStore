<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Count;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    use Count;
    // Menampilkan daftar semua pelanggan
    public function index()
    {
        $orderCount = $this->countOrdersBySeller();
        $user = Auth::user();
        $customers = Customer::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        
        return view('customers.index', compact('customers','orderCount','user', 'cartCount', 'wishListCount'));
    }

    public function data(Request $request)
    {
        // Filter dan pencarian berdasarkan nama pengguna
        $query = Customer::with('user'); // Include relasi dengan User
        if ($request->has('q') && !empty($request->q)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%');
            });
        }

        // Paginate data
        $customers = $query->paginate(10);

        return view('customers.data', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        if (!empty($customer->user->photo) && Storage::disk('public')->exists($customer->user->photo)) {
            Storage::disk('public')->delete($customer->user->photo);
        }

        $customer->user->delete();
        $customer->delete();

        return redirect()->route('customers.data')->with('success', 'Produk berhasil dihapus!');
    }

    public function listPesanan()
    {
        $orderCount = $this->countOrdersBySeller();
        $user = Auth::user();
        $customers = Customer::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $pesan = Order::where('customer_id', $customers->id)->get();
        return view('customers.list', compact('pesan','orderCount','user', 'cartCount', 'wishListCount'));
    }
    public function show($id)
    {
        $orderCount = $this->countOrdersBySeller();

        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $pesan = Order::find($id);
        $detail = OrderDetail::where('order_id', $pesan->id)->get();
        return view('customers.show', compact('pesan','orderCount','detail','customer','user', 'cartCount', 'wishListCount'));
    }

    // Mengupdate data pelanggan
    public function update(Request $request, Customer $customer)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);
        $user = User::find($customer->user_id);
        // Cek jika ada foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('images', 'public');
        } else {
            $photoPath = $user->photo;
        }

        // Update data pelanggan
        $customer->update([
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
        
        // Update nama pengguna jika perlu
        if ($request->filled('name')) {
            $customer->user->update([
                'name' => $request->name,
                'photo' => $photoPath,
            ]);
        }

        // Redirect ke halaman daftar pelanggan
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }
    public function confirmPayment($orderId)
    {
        $order = Order::with('products')->find($orderId);

        if ($order && $order->status === 'pending') {
            $order->status = 'paid';
            $order->save();

            return redirect()->route('customers.pesanan')->with('success', 'Payment confirmed successfully.');
        }elseif ($order && $order->status === 'process') {
            // Update status pesanan menjadi paid
            $order->status = 'done';
            $order->save();
    
            // Loop melalui setiap produk dalam pesanan
            foreach ($order->products as $product) {
                // Mengurangi stock produk berdasarkan quantity yang dibeli
                $product->stock -= $product->pivot->quantity;
    
                // Menambahkan sold berdasarkan quantity yang dibeli
                $product->sold += $product->pivot->quantity;
    
                // Simpan perubahan pada produk
                $product->save();
            }
        }

        return redirect()->route('customers.pesanan')->with('error', 'Unable to confirm payment.');
    }
}

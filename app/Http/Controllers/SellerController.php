<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    use Count;
    // Menampilkan daftar semua penjual
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $seller = Seller::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $orderCount = $this->countOrdersBySeller();
        return view('sellers.index', compact('seller','orderCount','customer','user', 'cartCount', 'wishListCount'));
    }
    public function data(Request $request)
    {
        // Filter dan pencarian berdasarkan nama toko
        $query = Seller::with('user'); // Include relasi dengan User
        if ($request->has('q') && !empty($request->q)) {
            $query->where('store_name', 'like', '%' . $request->q . '%')
                  ->orWhereHas('user', function ($query) use ($request) {
                      $query->where('name', 'like', "%{$request->q}%");
                  });
        }

        // Paginate data
        $sellers = $query->paginate(10);

        return view('sellers.data', compact('sellers'));
    }

    // Menyimpan data penjual baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'seller_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'seller_id' => $request->seller_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('sellers.toko')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateToko(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Update data produk
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('sellers.toko')->with('success', 'Produk berhasil diperbarui!');
    }

    public function listPesanan()
    {
        $user = Auth::user();
        $seller = Seller::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $orderCount = $this->countOrdersBySeller();
        $pesan = Order::where('seller_id', $seller->id)
        ->where('status', '!=','pending')
        ->get();
        return view('sellers.list', compact('pesan','orderCount','user', 'cartCount', 'wishListCount'));
    }
    public function show($id)
    {
        $user = Auth::user();
        $orderCount = $this->countOrdersBySeller();
        $seller = Seller::where('user_id', $user->id)->first();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $pesan = Order::with('customer.user')->find($id);
        $detail = OrderDetail::where('order_id', $pesan->id)->get();
        return view('sellers.show', compact('pesan','orderCount','detail','seller','user', 'cartCount', 'wishListCount'));
    }
    public function toko()
    {
        $user = Auth::user();
        $orderCount = $this->countOrdersBySeller();
        $categories = Category::all();
        $seller = Seller::where('user_id',$user->id)->first();
        $product = Product::where('seller_id', $seller->id)->get();
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        return view('sellers.toko', compact('categories','orderCount','seller','product', 'cartCount', 'wishListCount'));
    }
    
    public function update(Request $request, Seller $seller)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'store_name' => 'nullable|string|max:255',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find($seller->user_id);
        $customer = Customer::where('user_id', $user->id)->first();

        if ($request->hasFile('store_logo')) {
            if (!empty($seller->store_logo) && Storage::disk('public')->exists($seller->store_logo)) {
                Storage::disk('public')->delete($seller->store_logo);
            }
            $logo = $request->file('store_logo')->store('store', 'public');
        } else {
            $logo = $seller->store_logo;
        }

        if ($request->hasFile('photo')) {
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('images', 'public');
        } else {
            $photoPath = $user->photo;
        }

        $seller->update([
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'store_name' => $request->store_name,
            'store_logo' => $logo,
        ]);

        if ($request->filled('name')) {
            $user->update([
                'name' => $request->name,
                'photo' => $photoPath,
            ]);
        }

        return redirect()->route('sellers.index')->with('success', 'Penjual berhasil diperbarui.');
    }
    public function confirmOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->status !== 'confirm') {
            $order->status = 'confirm';
            $order->save();

            return redirect()->route('sellers.pesanan')->with('success', 'Order confirmed successfully.');
        }elseif ($order && $order->status !== 'process') {
            $order->status = 'process';
            $order->save();

            // Berikan respons dengan notifikasi sukses
            return redirect()->route('sellers.pesanan')->with('success', 'Order in process successfully.');
        }

        // Jika pesanan tidak ditemukan atau status sudah 'payment', kembalikan dengan error
        return redirect()->route('customers.pesanan')->with('error', 'Unable to confirm payment.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->photo && Storage::exists('public/' . $product->photo)) {
            Storage::delete('public/' . $product->photo);
        }

        $product->delete();

        return redirect()->route('sellers.toko')->with('success', 'Produk berhasil dihapus!');
    }
    public function delete($id)
    {
        $seller = Seller::with('user')->findOrFail($id);

        if (!empty($seller->user->photo) && Storage::disk('public')->exists($seller->user->photo)) {
            Storage::disk('public')->delete($seller->user->photo);
        }

        $seller->user->delete();
        $seller->delete();

        return redirect()->route('sellers.data')->with('success', 'Produk berhasil dihapus!');
    }
    
    public function countOrdersBySeller()
    {
        $user = Auth::user();
        $sellerId = Seller::where('user_id', $user->id)->first();
        $orderCount = Order::where('seller_id', $sellerId->id)
            ->where(function ($query) {
                $query->where('status', '!=', 'pending')
                      ->where('status', '!=', 'done')
                      ->where('status', '!=', 'rated');
            })
            ->count();

        return $orderCount;
    }
}

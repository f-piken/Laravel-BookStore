<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\WishList;
use App\Traits\Count;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    use Count;
    public function index()
    {   
        $orderCount = $this->countOrdersBySeller();

         $user = auth()->user();

         // Cari customer berdasarkan user_id
         $customer = Customer::where('user_id', $user->id)->first();
 
         if (!$customer) {
             return back()->with('error', 'Customer not found!');
         }
 
         // Ambil produk yang ada di wishlist untuk customer ini
         $wish = Wishlist::where('customer_id', $customer->id)
                                   ->with('product') // Memuat relasi produk
                                   ->get();
 
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        return view('wish.index', compact('wish', 'orderCount','cartCount', 'wishListCount'));
    }
    public function toggleWishlist(Request $request, $productId)
    {
        $user = auth()->user();

        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return back()->with('error', 'Customer not found!');
        }
    
        $product = Product::findOrFail($productId);

        $wishlistItem = Wishlist::where('customer_id', $customer->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Product removed from wishlist!');
        } else {
            Wishlist::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
            ]);
            return back()->with('success', 'Product added to wishlist!');
        }
    }

}

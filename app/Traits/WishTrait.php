<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\WishList;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

trait WishTrait
{
    /**
     * Menghitung jumlah item di keranjang berdasarkan customer ID.
     *
     * @return int
     */
    public function getCartCount()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if ($customer) {
            return Cart::where('customer_id', $customer->id)->count();
        }

        return 0; // Jika customer tidak ditemukan
    }

    /**
     * Menghitung jumlah item di wish list berdasarkan customer ID.
     *
     * @return int
     */
    public function getWishListCount()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if ($customer) {
            return WishList::where('customer_id', $customer->id)->count();
        }

        return 0; // Jika customer tidak ditemukan
    }
}

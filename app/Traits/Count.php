<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\WishList;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

trait Count
{
    /**
     * Menghitung jumlah item di keranjang berdasarkan customer ID.
     *
     * @return int
     */
    public function getCartCount()
    {
        $user = Auth::user();
        if ($user) {
            $customer = Customer::where('user_id', $user->id)->first();
            if($customer){
                return Cart::where('customer_id', $customer->id)->count();
            }
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
        if ($user) {
            $customer = Customer::where('user_id', $user->id)->first();
            if($customer){
                return WishList::where('customer_id', $customer->id)->count();
            }
        }

        return 0; // Jika customer tidak ditemukan
    }
    public function countOrdersBySeller()
    {
        $user = Auth::user();
        if(!$user){
            return 0;
        }elseif ($user->role == 'seller') {
            $seller = Seller::where('user_id', $user->id)->first();
            if (!$seller) {
                return 0;
            }
            $orderCount = Order::where('seller_id', $seller->id)
                ->where(function ($query) {
                    $query->where('status', '!=', 'pending')
                          ->where('status', '!=', 'done')
                          ->where('status', '!=', 'rated');
                })
                ->count();
            
            return $orderCount;
        } elseif ($user->role == 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            if (!$customer) {
                return 0;
            }
            $orderCount = Order::where('seller_id', $customer->id)
                ->where('status', '!=', 'rated')
                ->count();
        
            return $orderCount;
        }
    
        return 0;
    }

}

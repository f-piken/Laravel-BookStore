<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\WishList;
use App\Models\Viewer;
use App\Models\Order;
use App\Models\Editor;
use Illuminate\Support\Facades\Auth;

trait Count
{
    /**
     * Menghitung jumlah item di keranjang berdasarkan viewer ID.
     *
     * @return int
     */
    public function getCartCount()
    {
        $user = Auth::user();
        if ($user) {
            $viewer = Viewer::where('user_id', $user->id)->first();
            if($viewer){
                return Cart::where('viewer_id', $viewer->id)->count();
            }
        }

        return 0; // Jika viewer tidak ditemukan
    }

    /**
     * Menghitung jumlah item di wish list berdasarkan viewer ID.
     *
     * @return int
     */
    public function getWishListCount()
    {
        $user = Auth::user();
        if ($user) {
            $viewer = Viewer::where('user_id', $user->id)->first();
            if($viewer){
                return WishList::where('viewer_id', $viewer->id)->count();
            }
        }

        return 0; // Jika viewer tidak ditemukan
    }
    public function countOrdersByeditor()
    {
        $user = Auth::user();
        if(!$user){
            return 0;
        }elseif ($user->role == 'editor') {
            $editor = Editor::where('user_id', $user->id)->first();
            if (!$editor) {
                return 0;
            }
            $orderCount = Order::where('editor_id', $editor->id)
                ->where(function ($query) {
                    $query->where('status', '!=', 'pending')
                          ->where('status', '!=', 'done')
                          ->where('status', '!=', 'rated');
                })
                ->count();
            
            return $orderCount;
        } elseif ($user->role == 'viewer') {
            $viewer = Viewer::where('user_id', $user->id)->first();
            if (!$viewer) {
                return 0;
            }
            $orderCount = Order::where('editor_id', $viewer->id)
                ->where('status', '!=', 'rated')
                ->count();
        
            return $orderCount;
        }
    
        return 0;
    }

}

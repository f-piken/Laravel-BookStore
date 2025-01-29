<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Count;
    public function index()
    {
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();

        $mostSoldProducts = Product::orderBy('sold', 'desc')->take(4)->get();
        $highestRatedProducts = Product::orderBy('rate', 'desc')->take(4)->get();
    
        $topProducts = $mostSoldProducts->merge($highestRatedProducts)->unique('id');

        return view('index', compact('mostSoldProducts', 'orderCount','highestRatedProducts', 'topProducts', 'cartCount', 'wishListCount'));
    }

    public function bestSeller()
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }

        $mostSoldProducts = Product::orderBy('sold', 'desc')->take(20)->get();

        return view('best-seller', compact('mostSoldProducts',  'orderCount','cartCount', 'wishListCount'));
    }

    public function rating()
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }

        $highestRatedProducts = Product::orderBy('rate', 'desc')->take(20)->get();
        
        return view('top-rating', compact('highestRatedProducts','orderCount','cartCount', 'wishListCount'));
    }
    
    public function category()
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $categories = Category::all();
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }

        return view('category', compact('categories','orderCount','cartCount', 'wishListCount'));
    }

    public function getAllCategory()
    {
        $products = Product::all();
        
        return response()->json(['products' => $products]);
    }
    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        
        return response()->json(['products' => $products]);
    }
}

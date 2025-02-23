<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Count;
    public function index()
    {
        $book = Book::take(4)->get();

        return view('index', compact('book'));
    }

    public function bestSeller()
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();

        $mostSoldProducts = Book::orderBy('sold', 'desc')->take(20)->get();

        return view('best-seller', compact('mostSoldProducts','cartCount', 'wishListCount'));
    }

    public function rating()
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();

        $highestRatedProducts = Book::orderBy('rate', 'desc')->take(20)->get();
        
        return view('top-rating', compact('highestRatedProducts','cartCount', 'wishListCount'));
    }
    
    public function category()
    {
        $categories = Category::all();

        return view('category', compact('categories'));
    }

    public function getAllCategory()
    {
        $products = Book::all();
        
        return response()->json(['products' => $products]);
    }
    public function getbooksByCategory($categoryId)
    {
        $products = Book::where('category_id', $categoryId)->get();
        
        return response()->json(['products' => $products]);
    }
}

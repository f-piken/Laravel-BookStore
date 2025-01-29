<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use Count;
    public function index()
    {
        $query = Product::with('category', 'seller');
    
        // Filter berdasarkan pencarian
        if ($search = request('q')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('seller', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
        }
    
        $products = $query->paginate(10);
        return view('product.index', compact('products'));
    }

    public function cari(Request $request)
    {
        if(Auth::user()){
            $orderCount = $this->countOrdersBySeller();
        }else{
            $orderCount = 0;
        }

        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();

        $query = Product::query();

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'release_date':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rate', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc'); // Default sorting
            }
        }

        // Pagination limit
        $limit = $request->get('limit', 50);

        // Fetch categories (top 5)
        $categories = Category::take(5)->get();

        // Search functionality
        $q = $request->input('query');
        if ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%");
        }

        // Get paginated products
        $products = $query->paginate($limit);

        // Return the view
        return view('product.product', compact('products', 'orderCount','categories', 'cartCount', 'wishListCount'));
    }

    public function landing()
    {
        $mostSoldProducts = Product::orderBy('sold', 'desc')->take(4)->get();
        $highestRatedProducts = Product::orderBy('rate', 'desc')->take(4)->get();
    
        $topProducts = $mostSoldProducts->merge($highestRatedProducts)->unique('id');
    
        return view('products.index', compact('mostSoldProducts', 'highestRatedProducts', 'topProducts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'seller_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'rate' => 'nullable|numeric|min:0|max:5',
            'sold' => 'nullable|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|string',
        ]);

        $product = Product::create($request->validate);

        return response()->json(['message' => 'Product created successfully!', 'product' => $product], 201);
    }

    public function show($id)
    {
        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $orderCount = $this->countOrdersBySeller();

        $product = Product::with(['category', 'seller'])->findOrFail($id);
        return view('product.show', compact('product','orderCount','cartCount', 'wishListCount'));
    }

    public function rating($id)
    {
        $orderCount = $this->countOrdersBySeller();

        $cartCount = $this->getCartCount();
        $wishListCount = $this->getWishListCount();
        $order = Order::find($id);
        $cartItems = OrderDetail::where('order_id', $order->id)->with('product')->get();

        $cartTotal = $cartItems->sum('total_price');

        return view('customers.rating', compact('cartItems','orderCount','order','cartTotal','cartCount', 'wishListCount'));
    }

    public function rateMultipleProducts(Request $request, $id)
    {
        $order = Order::find($id);
        $request->validate([
            'ratings' => 'required|array',
            'ratings.*' => 'required|numeric|between:1,5',
        ]);

        foreach ($request->ratings as $productId => $rating) {
            $product = Product::find($productId);

            $existingRating = $product->rate * $product->sold + $rating; // Jika sold adalah jumlah produk yang dibeli
            $newRating = $existingRating / ($product->sold + 1);

            $product->update(['rate' => $newRating]);
        }
        if ($order && $order->status === 'done') {
            $order->status = 'rated';
            $order->save(); 

            return redirect()->route('customers.pesanan')->with('success', 'Order in process successfully.');
        }

        return redirect()->route('home')->with('success', 'Thank you for your feedback!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

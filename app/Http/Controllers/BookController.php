<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Book;
use App\Models\Editor;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    use Count;
    public function index()
    {
        $query = Book::with('category', 'editor');
    
        // Filter berdasarkan pencarian
        if ($search = request('q')) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($query) use ($search) {
                      $query->where('judul', 'like', "%{$search}%");
                  })
                  ->orWhereHas('editor', function ($query) use ($search) {
                      $query->where('judul', 'like', "%{$search}%");
                  });
        }
    
        $books = $query->paginate(10);
        $categories = Category::all();
        $editors = Editor::all();
        return view('book.index', compact('books', 'categories','editors'));
    }

    public function cari(Request $request)
    {
        $query = Book::query();

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
            $query->where('judul', 'like', "%$q%")
                ->orWhere('deskripsi', 'like', "%$q%");
        }

        // Get paginated Books
        $books = $query->paginate($limit);

        // Return the view
        return view('book.book', compact('books','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'editor_id' => 'required|exists:users,id',
            'tahun_terbit' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $imagePath = $request->file('image')->store('books', 'public');
        $editor = Editor::find($request->editor_id);
        Book::create([
            'editor_id' => $editor->id,
            'judul' => $request->judul,
            'penulis' => $editor->user->name,
            'tahun_terbit' => $request->tahun_terbit,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'image' => $imagePath,
        ]);
    
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $book = Book::findOrFail($id);

        if ($request->hasFile('image')) {
            if (!empty($book->image) && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }

            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->update([
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Buku berhasil diperbarui!');
    }

    public function show($id)
    {
        $book = Book::with(['category', 'editor'])->findOrFail($id);
        $user = Auth::user();
        if ($user->role === 'admin') {
            return view('book.admin-show', compact('book'));
        }else {
            return view('book.show', compact('book'));
        }
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if (!empty($book->image) && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return redirect()->route('admin-books.index')->with('success', 'Produk berhasil dihapus!');
    }
}

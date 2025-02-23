<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Viewer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Book;
use App\Models\Editor;
use App\Models\User;
use App\Traits\Count;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    use Count;
    // Menampilkan daftar semua penjual
    public function index()
    {
        $user = Auth::user();
        $viewer = Viewer::where('user_id', $user->id)->first();
        $editor = Editor::where('user_id', $user->id)->first();

        return view('editors.index', compact('editor','viewer','user'));
    }
    public function data(Request $request)
    {
        // Filter dan pencarian berdasarkan nama toko
        $query = Editor::with('user'); // Include relasi dengan User
        if ($request->has('q') && !empty($request->q)) {
            $query->where('store_name', 'like', '%' . $request->q . '%')
                  ->orWhereHas('user', function ($query) use ($request) {
                      $query->where('name', 'like', "%{$request->q}%");
                  });
        }

        // Paginate data
        $editors = $query->paginate(10);

        return view('editors.data', compact('editors'));
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

    public function updateBook(Request $request, $id)
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
    public function book()
    {
        $user = Auth::user();
        $categories = Category::all();
        $editor = Editor::where('user_id',$user->id)->first();
        $book = Book::where('editor_id', $editor->id)->get();

        return view('editors.book', compact('categories','editor','book'));
    }
    
    public function update(Request $request, Editor $editor)
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

        $user = User::find($editor->user_id);
        $viewer = Viewer::where('user_id', $user->id)->first();

        if ($request->hasFile('store_logo')) {
            if (!empty($editor->store_logo) && Storage::disk('public')->exists($editor->store_logo)) {
                Storage::disk('public')->delete($editor->store_logo);
            }
            $logo = $request->file('store_logo')->store('store', 'public');
        } else {
            $logo = $editor->store_logo;
        }

        if ($request->hasFile('photo')) {
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('images', 'public');
        } else {
            $photoPath = $user->photo;
        }

        $editor->update([
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

        return redirect()->route('editors.index')->with('success', 'Penjual berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->photo && Storage::exists('public/' . $book->photo)) {
            Storage::delete('public/' . $book->photo);
        }

        $book->delete();

        return redirect()->route('editors.book')->with('success', 'Produk berhasil dihapus!');
    }
    public function delete($id)
    {
        $editor = Editor::with('user')->findOrFail($id);

        if (!empty($editor->user->photo) && Storage::disk('public')->exists($editor->user->photo)) {
            Storage::disk('public')->delete($editor->user->photo);
        }

        $editor->user->delete();
        $editor->delete();

        return redirect()->route('editors.data')->with('success', 'Produk berhasil dihapus!');
    }
}

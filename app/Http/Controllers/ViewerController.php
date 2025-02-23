<?php

namespace App\Http\Controllers;

use App\Models\Viewer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Count;
use Illuminate\Support\Facades\Storage;

class ViewerController extends Controller
{
    use Count;
    // Menampilkan daftar semua pelanggan
    public function index()
    {
        $user = Auth::user();
        $viewers = Viewer::where('user_id', $user->id)->first();
        
        return view('viewers.index', compact('viewers','user'));
    }
    public function data(Request $request)
    {
        // Filter dan pencarian berdasarkan nama pengguna
        $query = Viewer::with('user'); // Include relasi dengan User
        if ($request->has('q') && !empty($request->q)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%');
            });
        }

        // Paginate data
        $viewers = $query->paginate(10);

        return view('viewers.data', compact('viewers'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $viewer = Viewer::findOrFail($id);

        $user = User::find($viewer->user_id);

        if ($request->hasFile('photo')) {
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('images', 'public');
        } else{
            $photoPath = $user->photo;
        }

        $viewer->update([
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
        
        if ($request->filled('name')) {
            $viewer->user->update([
                'name' => $request->name,
                'photo' => $photoPath,
            ]);
        }

        return redirect()->route('viewers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }
}

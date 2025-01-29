<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard.admin',compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $user = User::find($id);
        
        if ($request->hasFile('photo')) {
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('images', 'public');
        } else {
            $photoPath = $user->photo;
        }

        $user->update([
            'name' => $request->name,
            'photo' => $photoPath,
        ]);
        return redirect()->route('admin-dashboard.index')->with('success', 'User berhasil diperbarui.');
    }
}

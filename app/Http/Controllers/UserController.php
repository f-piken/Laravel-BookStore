<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use App\Models\User;
use App\Models\Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('q') && !empty($request->q)) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,editor,viewer',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'editor') {
            Editor::create(['user_id' => $user->id]);
        } elseif ($request->role === 'viewer') {
            Viewer::create(['user_id' => $user->id]);
        }

        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Registrasi pengguna berhasil!');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,editor,viewer',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->role === 'editor') {
            Editor::updateOrCreate(['user_id' => $user->id]);
            Viewer::where('user_id', $user->id)->delete();
        } elseif ($request->role === 'viewer') {
            Viewer::updateOrCreate(['user_id' => $user->id]);
            Editor::where('user_id', $user->id)->delete();
        } else {
            Editor::where('user_id', $user->id)->delete();
            Viewer::where('user_id', $user->id)->delete();
        }

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function editViewer($id)
    {
        $user = User::find($id);
        $viewer = Viewer::where('user_id', $user->id)->first();
        
        return view('users.edit-viewer', compact('viewer','user'));
    }
    public function updateViewer(Request $request, $id)
    {
        // Validasi input
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
        } else {
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

        return redirect()->route('admin-viewers.data')->with('success', 'Viewer berhasil diperbarui.');
    }
    public function editEditor($id)
    {
        $user = User::find($id);
        $editor = Editor::where('user_id', $user->id)->first();
        
        return view('users.edit-editor', compact('editor','user'));
    }
    public function updateEditor(Request $request, $id)
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

        $editor = Editor::findOrFail($id);
        $user = User::find($editor->user_id);

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

        return redirect()->route('admin-editors.data')->with('success', 'Editor berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!empty($user->image) && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}

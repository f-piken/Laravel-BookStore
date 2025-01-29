<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin-dashboard.index')->with('success', 'Login berhasil sebagai Admin!');
            } elseif ($user->role === 'seller') {
                return redirect()->route('home')->with('success', 'Login berhasil sebagai Seller!');
            } else {
                return redirect()->route('home')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password tidak valid']);
    }

    public function create()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:255',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if($request->role == 'seller'){
            Seller::create([
                'user_id' => $user->id,
            ]);
        }else{
            Customer::create([
                'user_id' => $user->id,
            ]);
        }

        $user->assignRole($request->role);
        auth()->login($user);

        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda telah logout');
    }
}

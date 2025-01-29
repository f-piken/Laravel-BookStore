<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan plural dari model
    protected $table = 'customers';

    // Tentukan atribut yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'phone',
        'province',
        'city',
        'postal_code',
        'address',
    ];

    // Relasi dengan model User (One to One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relasi ke Carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

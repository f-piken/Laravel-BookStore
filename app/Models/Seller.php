<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan plural dari model
    protected $table = 'sellers';

    // Tentukan atribut yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'phone',
        'province',
        'city',
        'postal_code',
        'address',
        'store_name',
        'store_logo',
    ];

    // Relasi dengan model User (One to One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

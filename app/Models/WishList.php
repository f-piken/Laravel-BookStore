<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika nama tabel berbeda dari konvensi
    protected $table = 'wish_lists';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'customer_id',
        'product_id',
    ];

    // Definisikan relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Definisikan relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

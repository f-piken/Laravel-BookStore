<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'description', 'price', 'rate','sold', 'stock', 'image'
    ];
    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function carts()
    {
        return $this->hasMany(cart::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
                    ->withPivot('quantity', 'price');
    }
}

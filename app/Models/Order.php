<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['seller_id','customer_id','delivery_option_id', 'order_number','subtotal', 'tax','total_amount', 'status'];

    // Relasi ke OrderItem
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function option()
    {
        return $this->belongsTo(DeliveryOption::class, 'delivery_option_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function deliveryOption()
    {
        return $this->belongsTo(DeliveryOption::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')
                    ->withPivot('quantity', 'price');
    }
}

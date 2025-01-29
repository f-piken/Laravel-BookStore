<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai di database
    protected $table = 'delivery_options';

    // Kolom yang dapat diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'code',
        'estimate',
        'cost',
    ];

    // Jika Anda ingin menghindari pengisian otomatis oleh timestamp
    public $timestamps = true;
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

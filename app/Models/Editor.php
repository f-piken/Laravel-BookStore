<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    use HasFactory;

    protected $table = 'editors';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

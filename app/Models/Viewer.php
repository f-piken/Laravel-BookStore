<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    use HasFactory;

    protected $table = 'viewers';

    protected $fillable = [
        'user_id',
        'phone',
        'province',
        'city',
        'postal_code',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

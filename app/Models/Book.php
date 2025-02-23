<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'editor_id', 'category_id', 'judul', 'penulis', 'tahun_terbit', 'deskripsi', 'image'
    ];
    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke editor
    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'content' ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

        public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

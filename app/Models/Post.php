<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Definiowanie relacji wielu do wielu z modelu Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

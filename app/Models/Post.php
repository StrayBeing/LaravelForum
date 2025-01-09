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
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
public function comments()
{
    return $this->hasMany(Comment::class);
}

public function votes()
{
    return $this->hasMany(Vote::class);
}
public function category()
{
    return $this->belongsTo(Category::class);
}
public function getTotalVotesAttribute()
{
    return $this->votes()->sum('vote'); // Sum of all votes (1 for upvotes, -1 for downvotes)
}
}

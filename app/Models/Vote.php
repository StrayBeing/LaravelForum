<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'vote',
    ];

    /**
     * Relacja do postu
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Relacja do użytkownika
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
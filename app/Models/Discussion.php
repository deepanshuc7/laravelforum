<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
    ];

    /**
     * Get the category that owns the discussion.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the discussion.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts for the discussion.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

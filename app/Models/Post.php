<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Specify which attributes are mass assignable
    protected $fillable = [
        'content',
        'discussion_id',
        'user_id',
    ];

    // Define the relationship with Discussion
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Tell Laravel it is safe to mass-assign these specific columns
    protected $fillable = ['title', 'content', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
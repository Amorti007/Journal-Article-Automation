<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['name', 'issn', 'description', 'cover_image', 'user_id', 'status', 'delete_requested'];

    // One-to-Many
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    // One-to-Many
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
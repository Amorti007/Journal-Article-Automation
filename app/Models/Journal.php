<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['name', 'issn', 'description', 'cover_image'];

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
}
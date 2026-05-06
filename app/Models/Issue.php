<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['journal_id', 'volume', 'number', 'year'];

    //One-to-Many
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    //One-to-Many
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
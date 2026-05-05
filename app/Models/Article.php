<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['user_id', 'journal_id', 'issue_id', 'title', 'abstract', 'pdf_path', 'status'];

    // One-to-Many
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    // One-to-Many
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // One-to-Many
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
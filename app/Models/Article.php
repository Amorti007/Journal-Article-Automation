<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const STATUS_EDITOR_REVIEW = 'editor_review';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'journal_id', 
        'issue_id', 
        'title', 
        'content',
        'abstract', 
        'pdf_path', 
        'file_path',
        'status'
    ];

    // --- Our Relationships ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // --- Teammates' Relationships ---
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}

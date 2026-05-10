<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'title', 'email', 'password', 'role', 'bio', 'profile_image', 'linkedin_url', 'website'])] // Profile fields added
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- İlişkiler (Relationships) ---

    /**
     * One-to-Many: Bir kullanıcının (Yazarın) birden fazla makalesi olabilir.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * One-to-Many: Bir kullanıcının (Editörün) sahip olduğu dergiler.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    // --- Yetki Yardımcıları (Role Helpers) ---

    /**
     * Blade şablonlarında ve Controller içinde hızlı rol kontrolü sağlar.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isReader(): bool
    {
        return $this->role === 'reader';
    }
}

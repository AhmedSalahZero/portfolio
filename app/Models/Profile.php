<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'headline',
        'bio',
        'location',
        'email',
        'phone',
        'years_experience',
        'availability',
        'avatar_path',
        'cv_path',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'website_url',
        'stats',
    ];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'years_experience' => 'integer',
        ];
    }

    /**
     * The single site profile. Falls back to a fresh instance so the API never breaks.
     */
    public static function current(): self
    {
        return static::query()->first() ?? new self();
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? Storage::url($this->avatar_path) : null;
    }

    public function getCvUrlAttribute(): ?string
    {
        return $this->cv_path ? Storage::url($this->cv_path) : null;
    }
}

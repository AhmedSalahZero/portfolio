<?php

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Profile */
class ProfileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'headline' => $this->headline,
            'bio' => $this->bio,
            'location' => $this->location,
            'email' => $this->email,
            'phone' => $this->phone,
            'years_experience' => $this->years_experience,
            'availability' => $this->availability,
            'avatar_url' => $this->avatar_url,
            'cv_url' => $this->cv_url,
            'social' => [
                'github' => $this->github_url,
                'linkedin' => $this->linkedin_url,
                'twitter' => $this->twitter_url,
                'website' => $this->website_url,
            ],
            'stats' => $this->stats ?? [],
        ];
    }
}

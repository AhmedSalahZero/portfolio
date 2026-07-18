<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lightweight representation used in the projects grid.
 *
 * @mixin Project
 */
class ProjectSummaryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'tagline' => $this->tagline,
            'summary' => $this->summary,
            'category' => $this->category,
            'role' => $this->role,
            'year' => $this->year,
            'cover_image' => $this->cover_image_url,
            'live_url' => $this->live_url,
            'repo_url' => $this->repo_url,
            'is_featured' => $this->is_featured,
            'metrics' => $this->metrics ?? [],
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
        ];
    }
}

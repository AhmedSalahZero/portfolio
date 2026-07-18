<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full case-study representation used on the project detail page and in admin.
 *
 * @mixin Project
 */
class ProjectResource extends JsonResource
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
            'category' => $this->category,
            'role' => $this->role,
            'client' => $this->client,
            'year' => $this->year,
            'summary' => $this->summary,
            'problem' => $this->problem,
            'solution' => $this->solution,
            'outcome' => $this->outcome,
            'highlights' => $this->highlights ?? [],
            'metrics' => $this->metrics ?? [],
            'cover_image' => $this->cover_image_url,
            'live_url' => $this->live_url,
            'repo_url' => $this->repo_url,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'sort_order' => $this->sort_order,
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'skill_ids' => $this->whenLoaded('skills', fn () => $this->skills->pluck('id')),
            'images' => ProjectImageResource::collection($this->whenLoaded('images')),
        ];
    }
}

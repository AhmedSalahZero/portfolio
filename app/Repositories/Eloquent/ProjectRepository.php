<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    protected function model(): string
    {
        return Project::class;
    }

    public function published(?string $skill = null, ?string $category = null): Collection
    {
        return $this->query()
            ->published()
            ->with(['skills', 'images'])
            ->when($skill, fn ($query) => $query->whereHas(
                'skills',
                fn ($q) => $q->where('name', $skill)
            ))
            ->when($category, fn ($query) => $query->where('category', $category))
            ->ordered()
            ->get();
    }

    public function featured(): Collection
    {
        return $this->query()
            ->published()
            ->featured()
            ->with('skills')
            ->ordered()
            ->get();
    }

    public function findPublishedBySlug(string $slug): ?Project
    {
        return $this->query()
            ->published()
            ->with(['skills', 'images'])
            ->where('slug', $slug)
            ->first();
    }

    public function syncSkills(Project $project, array $skillIds): void
    {
        $payload = [];

        foreach (array_values($skillIds) as $index => $skillId) {
            $payload[$skillId] = ['sort_order' => $index];
        }

        $project->skills()->sync($payload);
    }
}

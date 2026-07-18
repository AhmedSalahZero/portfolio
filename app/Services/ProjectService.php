<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function __construct(private readonly ProjectRepositoryInterface $projects)
    {
    }

    public function listPublished(?string $skill = null, ?string $category = null): Collection
    {
        return $this->projects->published($skill, $category);
    }

    public function findPublished(string $slug): ?Project
    {
        return $this->projects->findPublishedBySlug($slug);
    }

    public function listAll(): Collection
    {
        return $this->projects->query()->with('skills')->ordered()->get();
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<int, int>  $skillIds
     */
    public function create(array $attributes, array $skillIds = []): Project
    {
        return DB::transaction(function () use ($attributes, $skillIds) {
            /** @var Project $project */
            $project = $this->projects->create($attributes);
            $this->projects->syncSkills($project, $skillIds);

            return $project->load('skills');
        });
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<int, int>|null  $skillIds
     */
    public function update(Project $project, array $attributes, ?array $skillIds = null): Project
    {
        return DB::transaction(function () use ($project, $attributes, $skillIds) {
            $project = $this->projects->update($project, $attributes);

            if (! is_null($skillIds)) {
                $this->projects->syncSkills($project, $skillIds);
            }

            return $project->load('skills');
        });
    }

    public function delete(Project $project): void
    {
        $this->projects->delete($project);
    }
}

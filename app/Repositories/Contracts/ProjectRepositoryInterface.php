<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    /**
     * Published projects, optionally filtered by a skill name and/or category.
     */
    public function published(?string $skill = null, ?string $category = null): Collection;

    public function featured(): Collection;

    public function findPublishedBySlug(string $slug): ?Project;

    public function syncSkills(Project $project, array $skillIds): void;
}

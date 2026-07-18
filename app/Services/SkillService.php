<?php

namespace App\Services;

use App\Models\Skill;
use App\Repositories\Contracts\SkillRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class SkillService
{
    public function __construct(private readonly SkillRepositoryInterface $skills)
    {
    }

    public function ordered(): Collection
    {
        return $this->skills->ordered();
    }

    public function groupedByCategory(): SupportCollection
    {
        return $this->skills->groupedByCategory();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Skill
    {
        /** @var Skill $skill */
        $skill = $this->skills->create($attributes);

        return $skill;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(Skill $skill, array $attributes): Skill
    {
        /** @var Skill $updated */
        $updated = $this->skills->update($skill, $attributes);

        return $updated;
    }

    public function delete(Skill $skill): void
    {
        $this->skills->delete($skill);
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Models\Skill;
use App\Repositories\Contracts\SkillRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class SkillRepository extends BaseRepository implements SkillRepositoryInterface
{
    protected function model(): string
    {
        return Skill::class;
    }

    public function ordered(): Collection
    {
        return $this->query()->ordered()->get();
    }

    public function groupedByCategory(): SupportCollection
    {
        return $this->ordered()->groupBy(fn (Skill $skill) => $skill->category->value);
    }
}

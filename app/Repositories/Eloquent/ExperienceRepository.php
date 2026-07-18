<?php

namespace App\Repositories\Eloquent;

use App\Models\Experience;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExperienceRepository extends BaseRepository implements ExperienceRepositoryInterface
{
    protected function model(): string
    {
        return Experience::class;
    }

    public function ordered(): Collection
    {
        return $this->query()->ordered()->get();
    }
}

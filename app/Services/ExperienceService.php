<?php

namespace App\Services;

use App\Models\Experience;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExperienceService
{
    public function __construct(private readonly ExperienceRepositoryInterface $experiences)
    {
    }

    public function ordered(): Collection
    {
        return $this->experiences->ordered();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Experience
    {
        /** @var Experience $experience */
        $experience = $this->experiences->create($attributes);

        return $experience;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(Experience $experience, array $attributes): Experience
    {
        /** @var Experience $updated */
        $updated = $this->experiences->update($experience, $attributes);

        return $updated;
    }

    public function delete(Experience $experience): void
    {
        $this->experiences->delete($experience);
    }
}

<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ExperienceRepositoryInterface extends RepositoryInterface
{
    public function ordered(): Collection;
}

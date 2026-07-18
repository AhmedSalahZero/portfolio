<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

interface SkillRepositoryInterface extends RepositoryInterface
{
    public function ordered(): Collection;

    /**
     * Skills grouped by their category value.
     */
    public function groupedByCategory(): SupportCollection;
}

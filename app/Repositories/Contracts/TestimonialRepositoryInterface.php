<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TestimonialRepositoryInterface extends RepositoryInterface
{
    public function ordered(): Collection;
}

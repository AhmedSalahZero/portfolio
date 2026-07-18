<?php

namespace App\Repositories\Eloquent;

use App\Models\Testimonial;
use App\Repositories\Contracts\TestimonialRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TestimonialRepository extends BaseRepository implements TestimonialRepositoryInterface
{
    protected function model(): string
    {
        return Testimonial::class;
    }

    public function ordered(): Collection
    {
        return $this->query()->ordered()->get();
    }
}

<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Repositories\Contracts\TestimonialRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TestimonialService
{
    public function __construct(private readonly TestimonialRepositoryInterface $testimonials)
    {
    }

    public function ordered(): Collection
    {
        return $this->testimonials->ordered();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Testimonial
    {
        /** @var Testimonial $testimonial */
        $testimonial = $this->testimonials->create($attributes);

        return $testimonial;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(Testimonial $testimonial, array $attributes): Testimonial
    {
        /** @var Testimonial $updated */
        $updated = $this->testimonials->update($testimonial, $attributes);

        return $updated;
    }

    public function delete(Testimonial $testimonial): void
    {
        $this->testimonials->delete($testimonial);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;

class TestimonialController extends ApiController
{
    public function __construct(private readonly TestimonialService $testimonials)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok(TestimonialResource::collection($this->testimonials->ordered()));
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        $testimonial = $this->testimonials->create($request->validated());

        return $this->created(new TestimonialResource($testimonial), 'Testimonial created.');
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $testimonial = $this->testimonials->update($testimonial, $request->validated());

        return $this->ok(new TestimonialResource($testimonial), 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $this->testimonials->delete($testimonial);

        return $this->ok(message: 'Testimonial deleted.');
    }
}

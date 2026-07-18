<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TestimonialResource;
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ExperienceResource;
use App\Services\ExperienceService;
use Illuminate\Http\JsonResponse;

class ExperienceController extends ApiController
{
    public function __construct(private readonly ExperienceService $experiences)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok(ExperienceResource::collection($this->experiences->ordered()));
    }
}

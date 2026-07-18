<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SkillResource;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;

class SkillController extends ApiController
{
    public function __construct(private readonly SkillService $skills)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok(SkillResource::collection($this->skills->ordered()));
    }
}

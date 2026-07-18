<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ExperienceResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ProjectSummaryResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\TestimonialResource;
use App\Services\ExperienceService;
use App\Services\ProfileService;
use App\Services\ProjectService;
use App\Services\SkillService;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;

/**
 * Aggregated payload for the landing page so the SPA can hydrate in one request.
 */
class SiteController extends ApiController
{
    public function __construct(
        private readonly ProfileService $profiles,
        private readonly SkillService $skills,
        private readonly ProjectService $projects,
        private readonly ExperienceService $experiences,
        private readonly TestimonialService $testimonials,
    ) {
    }

    public function index(): JsonResponse
    {
        return $this->ok([
            'profile' => new ProfileResource($this->profiles->current()),
            'skills' => SkillResource::collection($this->skills->ordered()),
            'projects' => ProjectSummaryResource::collection($this->projects->listPublished()),
            'experiences' => ExperienceResource::collection($this->experiences->ordered()),
            'testimonials' => TestimonialResource::collection($this->testimonials->ordered()),
        ]);
    }
}

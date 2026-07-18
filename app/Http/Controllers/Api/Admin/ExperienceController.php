<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
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

    public function store(ExperienceRequest $request): JsonResponse
    {
        $experience = $this->experiences->create($request->validated());

        return $this->created(new ExperienceResource($experience), 'Experience created.');
    }

    public function update(ExperienceRequest $request, Experience $experience): JsonResponse
    {
        $experience = $this->experiences->update($experience, $request->validated());

        return $this->ok(new ExperienceResource($experience), 'Experience updated.');
    }

    public function destroy(Experience $experience): JsonResponse
    {
        $this->experiences->delete($experience);

        return $this->ok(message: 'Experience deleted.');
    }
}

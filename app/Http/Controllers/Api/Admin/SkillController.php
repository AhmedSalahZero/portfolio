<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\SkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
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

    public function store(SkillRequest $request): JsonResponse
    {
        $skill = $this->skills->create($request->validated());

        return $this->created(new SkillResource($skill), 'Skill created.');
    }

    public function update(SkillRequest $request, Skill $skill): JsonResponse
    {
        $skill = $this->skills->update($skill, $request->validated());

        return $this->ok(new SkillResource($skill), 'Skill updated.');
    }

    public function destroy(Skill $skill): JsonResponse
    {
        $this->skills->delete($skill);

        return $this->ok(message: 'Skill deleted.');
    }
}

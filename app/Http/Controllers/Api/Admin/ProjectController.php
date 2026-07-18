<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
    public function __construct(private readonly ProjectService $projects)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok(ProjectResource::collection($this->projects->listAll()));
    }

    public function show(Project $project): JsonResponse
    {
        return $this->ok(new ProjectResource($project->load(['skills', 'images'])));
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        $project = $this->projects->create(
            $request->attributesData(),
            $request->skillIds() ?? [],
        );

        return $this->created(new ProjectResource($project->load(['skills', 'images'])), 'Project created.');
    }

    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->projects->update(
            $project,
            $request->attributesData(),
            $request->skillIds(),
        );

        return $this->ok(new ProjectResource($project->load(['skills', 'images'])), 'Project updated.');
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->projects->delete($project);

        return $this->ok(message: 'Project deleted.');
    }
}

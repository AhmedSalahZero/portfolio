<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectSummaryResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    public function __construct(private readonly ProjectService $projects)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $projects = $this->projects->listPublished(
            skill: $request->query('skill'),
            category: $request->query('category'),
        );

        return $this->ok(ProjectSummaryResource::collection($projects));
    }

    public function show(string $slug): JsonResponse
    {
        $project = $this->projects->findPublished($slug);

        if (! $project instanceof Project) {
            return $this->fail('Project not found.', 404);
        }

        return $this->ok(new ProjectResource($project));
    }
}

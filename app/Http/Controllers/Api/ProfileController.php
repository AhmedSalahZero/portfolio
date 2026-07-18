<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends ApiController
{
    public function __construct(private readonly ProfileService $profiles)
    {
    }

    public function show(): JsonResponse
    {
        return $this->ok(new ProfileResource($this->profiles->current()));
    }
}

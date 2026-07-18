<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ProfileRequest;
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

    public function update(ProfileRequest $request): JsonResponse
    {
        $profile = $this->profiles->update($request->validated());

        return $this->ok(new ProfileResource($profile), 'Profile updated.');
    }
}

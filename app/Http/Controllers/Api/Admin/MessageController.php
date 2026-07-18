<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Http\JsonResponse;

class MessageController extends ApiController
{
    public function __construct(private readonly ContactMessageRepositoryInterface $messages)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok(ContactMessageResource::collection($this->messages->paginateLatest(20)));
    }

    public function show(ContactMessage $message): JsonResponse
    {
        $message->markAsRead();

        return $this->ok(new ContactMessageResource($message));
    }

    public function destroy(ContactMessage $message): JsonResponse
    {
        $this->messages->delete($message);

        return $this->ok(message: 'Message deleted.');
    }
}

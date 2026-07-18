<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ContactMessageData;
use App\Http\Requests\StoreContactRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends ApiController
{
    public function __construct(private readonly ContactService $contact)
    {
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $this->contact->handle(
            ContactMessageData::fromArray($request->validatedData(), $request->ip()),
        );

        return $this->created(
            message: 'Thanks for reaching out — I will get back to you shortly.',
        );
    }
}

<?php

namespace App\Services;

use App\DataTransferObjects\ContactMessageData;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Profile;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function __construct(private readonly ContactMessageRepositoryInterface $messages)
    {
    }

    /**
     * Persist an inbound contact message and notify the site owner by email.
     */
    public function handle(ContactMessageData $data): ContactMessage
    {
        /** @var ContactMessage $message */
        $message = $this->messages->create($data->toArray());

        $this->notifyOwner($message);

        return $message;
    }

    private function notifyOwner(ContactMessage $message): void
    {
        $recipient = Profile::current()->email ?: config('mail.from.address');

        if (blank($recipient)) {
            return;
        }

        try {
            Mail::to($recipient)->queue(new ContactMessageReceived($message));
        } catch (\Throwable $e) {
            // Never fail the request because the mail transport is misconfigured.
            Log::warning('Failed to queue contact notification', ['error' => $e->getMessage()]);
        }
    }
}

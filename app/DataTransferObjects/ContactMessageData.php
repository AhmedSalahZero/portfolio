<?php

namespace App\DataTransferObjects;

/**
 * Immutable representation of an inbound contact submission, decoupling the
 * HTTP request shape from the service/persistence layer.
 */
final readonly class ContactMessageData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $subject,
        public string $message,
        public ?string $ipAddress = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data, ?string $ipAddress = null): self
    {
        return new self(
            name: (string) $data['name'],
            email: (string) $data['email'],
            subject: $data['subject'] ?? null,
            message: (string) $data['message'],
            ipAddress: $ipAddress,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'ip_address' => $this->ipAddress,
        ];
    }
}

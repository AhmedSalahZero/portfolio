<?php

namespace Tests\Unit;

use App\DataTransferObjects\ContactMessageData;
use PHPUnit\Framework\TestCase;

class ContactMessageDataTest extends TestCase
{
    public function test_it_builds_from_array_and_captures_ip(): void
    {
        $data = ContactMessageData::fromArray([
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'subject' => 'Hi',
            'message' => 'Hello there',
        ], '127.0.0.1');

        $this->assertSame('Jane', $data->name);
        $this->assertSame('127.0.0.1', $data->ipAddress);
        $this->assertSame('jane@example.com', $data->toArray()['email']);
    }

    public function test_subject_is_optional(): void
    {
        $data = ContactMessageData::fromArray([
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'message' => 'Hello there',
        ]);

        $this->assertNull($data->subject);
    }
}

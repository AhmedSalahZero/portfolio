<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_valid_contact_message_and_queues_mail(): void
    {
        Mail::fake();
        Profile::factory()->create(['email' => 'owner@example.com']);

        $payload = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Hiring',
            'message' => 'We would love to work with you on a new project.',
        ];

        $this->postJson('/api/contact', $payload)
            ->assertCreated()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'jane@example.com',
            'subject' => 'Hiring',
        ]);

        Mail::assertQueued(ContactMessageReceived::class);
    }

    public function test_it_validates_required_fields(): void
    {
        $this->postJson('/api/contact', [])
            ->assertStatus(422)
            ->assertJsonPath('success', false);

        $this->assertSame(0, ContactMessage::query()->count());
    }

    public function test_it_rejects_submissions_that_fill_the_honeypot(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'message' => 'This is spam content for the honeypot test.',
            'website' => 'http://spam.example.com',
        ];

        $this->postJson('/api/contact', $payload)->assertStatus(422);

        $this->assertSame(0, ContactMessage::query()->count());
    }
}

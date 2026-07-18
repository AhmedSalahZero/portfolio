<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@portfolio.test',
            'password' => Hash::make('secret-password'),
        ]);

        $this->postJson('/api/admin/login', [
            'email' => 'admin@portfolio.test',
            'password' => 'secret-password',
        ])
            ->assertOk()
            ->assertJsonStructure(['data' => ['token', 'user' => ['id', 'name', 'email']]]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@portfolio.test',
            'password' => Hash::make('secret-password'),
        ]);

        $this->postJson('/api/admin/login', [
            'email' => 'admin@portfolio.test',
            'password' => 'wrong',
        ])->assertStatus(422);
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->getJson('/api/admin/projects')->assertUnauthorized();
    }

    public function test_authenticated_admin_can_create_a_project(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/admin/projects', [
            'title' => 'New Case Study',
            'tagline' => 'A great project tagline.',
            'summary' => 'A summary of the project that is long enough.',
            'is_published' => true,
        ]);

        $response->assertCreated()->assertJsonPath('data.title', 'New Case Study');
        $this->assertDatabaseHas('projects', ['slug' => 'new-case-study']);
    }

    public function test_authenticated_admin_can_delete_a_project(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $project = Project::factory()->create();

        $this->deleteJson("/api/admin/projects/{$project->slug}")->assertOk();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}

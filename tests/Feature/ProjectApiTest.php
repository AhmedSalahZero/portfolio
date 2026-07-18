<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_only_published_projects(): void
    {
        Project::factory()->count(2)->create();
        Project::factory()->unpublished()->create();

        $response = $this->getJson('/api/projects');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    public function test_it_filters_projects_by_skill(): void
    {
        $laravel = Skill::factory()->create(['name' => 'Laravel']);
        $vue = Skill::factory()->create(['name' => 'Vue 3']);

        $a = Project::factory()->create();
        $a->skills()->attach($laravel);

        $b = Project::factory()->create();
        $b->skills()->attach($vue);

        $response = $this->getJson('/api/projects?skill=Laravel');

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $this->assertSame($a->slug, $response->json('data.0.slug'));
    }

    public function test_it_shows_a_project_by_slug(): void
    {
        $project = Project::factory()->create();

        $this->getJson("/api/projects/{$project->slug}")
            ->assertOk()
            ->assertJsonPath('data.title', $project->title)
            ->assertJsonPath('success', true);
    }

    public function test_it_returns_404_for_missing_project(): void
    {
        $this->getJson('/api/projects/does-not-exist')
            ->assertNotFound()
            ->assertJsonPath('success', false);
    }

    public function test_unpublished_project_is_not_visible(): void
    {
        $project = Project::factory()->unpublished()->create();

        $this->getJson("/api/projects/{$project->slug}")->assertNotFound();
    }
}

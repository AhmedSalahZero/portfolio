<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    private function service(): ProjectService
    {
        return app(ProjectService::class);
    }

    public function test_create_persists_project_and_syncs_skills(): void
    {
        $skills = Skill::factory()->count(3)->create();

        $project = $this->service()->create([
            'title' => 'Service Created Project',
            'tagline' => 'Tagline here',
            'summary' => 'A sufficiently long summary of the project.',
            'is_published' => true,
        ], $skills->pluck('id')->all());

        $this->assertDatabaseHas('projects', ['slug' => 'service-created-project']);
        $this->assertCount(3, $project->skills);
    }

    public function test_update_can_replace_skill_associations(): void
    {
        $initial = Skill::factory()->count(2)->create();
        $replacement = Skill::factory()->create();

        $project = $this->service()->create([
            'title' => 'Updatable Project',
            'tagline' => 'Tagline',
            'summary' => 'A sufficiently long summary of the project.',
        ], $initial->pluck('id')->all());

        $updated = $this->service()->update($project, ['role' => 'Lead Engineer'], [$replacement->id]);

        $this->assertSame('Lead Engineer', $updated->role);
        $this->assertCount(1, $updated->skills);
        $this->assertSame($replacement->id, $updated->skills->first()->id);
    }

    public function test_list_published_excludes_drafts(): void
    {
        Project::factory()->count(2)->create();
        Project::factory()->unpublished()->create();

        $this->assertCount(2, $this->service()->listPublished());
    }
}

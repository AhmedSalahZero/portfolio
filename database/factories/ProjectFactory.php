<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 99999),
            'tagline' => $this->faker->sentence(),
            'category' => $this->faker->word(),
            'role' => 'Full-Stack Developer',
            'year' => $this->faker->numberBetween(2020, (int) date('Y')),
            'summary' => $this->faker->paragraph(),
            'highlights' => [$this->faker->sentence(), $this->faker->sentence()],
            'metrics' => [['label' => 'Models', 'value' => (string) $this->faker->numberBetween(10, 100)]],
            'is_featured' => $this->faker->boolean(),
            'is_published' => true,
            'sort_order' => $this->faker->numberBetween(0, 50),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}

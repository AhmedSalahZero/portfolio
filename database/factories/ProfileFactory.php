<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => 'Senior Full-Stack Engineer',
            'headline' => $this->faker->sentence(),
            'bio' => $this->faker->paragraph(),
            'email' => $this->faker->safeEmail(),
            'years_experience' => $this->faker->numberBetween(3, 12),
            'stats' => [],
        ];
    }
}

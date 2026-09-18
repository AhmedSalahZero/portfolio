<?php

namespace Database\Seeders;

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            SkillCategory::Backend->value => [
                ['PHP', 95, true],
                ['Laravel', 95, true],
                ['REST API Design', 92, true],
                ['Authentication & Sanctum', 88, false],
                ['Queues & Background Jobs', 85, false],
                ['Real-time / WebSockets', 82, false],
                ['Node.js (basic)', 45, false],
                ['Python (basic)', 45, false],
            ],
            SkillCategory::Frontend->value => [
                ['Vue 3', 90, true],
                ['TypeScript', 85, true],
                ['JavaScript (ES6+)', 88, false],
                ['Tailwind CSS', 90, true],
                ['Inertia.js', 84, false],
                ['Pinia', 80, false],
                ['HTML5 & CSS3', 90, false],
            ],
            SkillCategory::Database->value => [
                ['MySQL', 92, true],
                ['Eloquent ORM', 92, false],
                ['Query Optimization', 85, false],
                ['Redis', 78, false],
            ],
            SkillCategory::DevOps->value => [
                ['Docker', 80, true],
                ['CI/CD Pipelines', 78, false],
                ['AWS', 68, false],
                ['Vagrant', 65, false],
                ['Nginx', 76, false],
                ['Linux', 82, false],
                ['Git', 90, false],
            ],
            SkillCategory::Tools->value => [
                ['PHPUnit / Pest', 82, true],
                ['Firebase', 80, false],
                ['Twilio', 78, false],
                ['Payment Gateways', 80, false],
                ['Google Maps API', 78, false],
                ['WhatsApp Cloud API', 85, true],
                ['OpenAI API', 80, false],
                ['Odoo ERP', 78, false],
                ['PHPStan / Larastan', 85, false],
            ],
        ];

        $sort = 0;

        foreach ($groups as $category => $skills) {
            foreach ($skills as [$name, $level, $featured]) {
                Skill::updateOrCreate(
                    ['name' => $name],
                    [
                        'category' => $category,
                        'level' => $level,
                        'is_featured' => $featured,
                        'sort_order' => $sort++,
                    ],
                );
            }
        }
    }
}

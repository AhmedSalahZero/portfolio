<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Ahmed Salah Helmy',
                'title' => 'Senior Software Developer',
                'headline' => 'I build scalable SaaS platforms, ERP-integrated systems, and mobile APIs with Laravel, Vue 3, and MySQL.',
                'bio' => "I'm a Senior Software Developer with 6+ years building production-grade SaaS platforms, "
                    ."enterprise ERP-integrated systems, and mobile APIs. I specialize in Laravel/PHP, Vue 3, "
                    ."real-time architectures, and multi-tenant SaaS, with hands-on experience integrating Python "
                    ."scripts into Laravel workflows for data processing and automation. I care deeply about clean "
                    ."architecture, SOLID principles, and building systems that stay maintainable as they grow — "
                    ."from multi-tenant WhatsApp Business platforms and enterprise finance suites to geospatial "
                    ."ride-hailing backends and multi-vendor marketplaces. I hold a B.Sc. in Computer Science from "
                    ."Al-Azhar University (2nd in class, Very Good honors) and a Pre-Master's in CS.",
                'location' => 'Cairo, Egypt',
                'email' => 'asalahdev5@gmail.com',
                'phone' => '+20 10 2589 4984',
                'years_experience' => 6,
                'availability' => 'Open to remote opportunities',
                'github_url' => 'https://github.com/AhmedSalahZero',
                'linkedin_url' => 'https://www.linkedin.com/in/ahmed-salah-a847841b5',
                'twitter_url' => null,
                'website_url' => null,
                'cv_path' => 'cv/ahmed-salah-cv.pdf',
                'stats' => [
                    ['label' => 'Years Experience', 'value' => '6+'],
                    ['label' => 'Production Projects', 'value' => '15+'],
                    ['label' => 'Domains Delivered', 'value' => '8+'],
                    ['label' => 'Core Stack', 'value' => 'Laravel · Vue 3'],
                ],
            ],
        );
    }
}

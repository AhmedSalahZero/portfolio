<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        // No testimonials yet. The Testimonials section on the site hides itself
        // automatically while this table is empty. Add real quotes here (or via
        // the admin panel) once you have them.
        $rows = [];

        foreach ($rows as $row) {
            Testimonial::updateOrCreate(
                ['author' => $row['author'], 'company' => $row['company']],
                $row,
            );
        }
    }
}

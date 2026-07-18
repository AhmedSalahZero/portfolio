<?php

namespace Tests\Unit;

use App\Enums\SkillCategory;
use PHPUnit\Framework\TestCase;

class SkillCategoryTest extends TestCase
{
    public function test_values_returns_all_case_values(): void
    {
        $values = SkillCategory::values();

        $this->assertContains('backend', $values);
        $this->assertContains('frontend', $values);
        $this->assertCount(5, $values);
    }

    public function test_each_category_has_a_human_label(): void
    {
        foreach (SkillCategory::cases() as $category) {
            $this->assertNotEmpty($category->label());
        }
    }
}

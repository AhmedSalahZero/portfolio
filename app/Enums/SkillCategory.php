<?php

namespace App\Enums;

enum SkillCategory: string
{
    case Backend = 'backend';
    case Frontend = 'frontend';
    case Database = 'database';
    case DevOps = 'devops';
    case Tools = 'tools';

    public function label(): string
    {
        return match ($this) {
            self::Backend => 'Backend',
            self::Frontend => 'Frontend',
            self::Database => 'Databases',
            self::DevOps => 'DevOps & Cloud',
            self::Tools => 'Tools & Practices',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $c) => $c->value, self::cases());
    }
}

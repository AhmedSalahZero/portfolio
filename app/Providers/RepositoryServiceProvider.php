<?php

namespace App\Providers;

use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\SkillRepositoryInterface;
use App\Repositories\Contracts\TestimonialRepositoryInterface;
use App\Repositories\Eloquent\ContactMessageRepository;
use App\Repositories\Eloquent\ExperienceRepository;
use App\Repositories\Eloquent\ProjectRepository;
use App\Repositories\Eloquent\SkillRepository;
use App\Repositories\Eloquent\TestimonialRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind repository contracts to their Eloquent implementations so consumers
     * depend on abstractions, not concretions (Dependency Inversion Principle).
     *
     * @var array<class-string, class-string>
     */
    private array $repositories = [
        ProjectRepositoryInterface::class => ProjectRepository::class,
        SkillRepositoryInterface::class => SkillRepository::class,
        ExperienceRepositoryInterface::class => ExperienceRepository::class,
        TestimonialRepositoryInterface::class => TestimonialRepository::class,
        ContactMessageRepositoryInterface::class => ContactMessageRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->repositories as $contract => $implementation) {
            $this->app->bind($contract, $implementation);
        }
    }
}

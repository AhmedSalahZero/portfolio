<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Http\JsonResponse;

class DashboardController extends ApiController
{
    public function __construct(private readonly ContactMessageRepositoryInterface $messages)
    {
    }

    public function index(): JsonResponse
    {
        return $this->ok([
            'projects' => Project::query()->count(),
            'published_projects' => Project::query()->published()->count(),
            'skills' => Skill::query()->count(),
            'experiences' => Experience::query()->count(),
            'testimonials' => Testimonial::query()->count(),
            'unread_messages' => $this->messages->unreadCount(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * Serves the Vue SPA shell while rendering per-page SEO/social meta tags
 * server-side, so crawlers and link unfurlers (LinkedIn, WhatsApp, Slack)
 * receive correct titles, descriptions, and preview images. The SPA still
 * hydrates its data from the JSON API.
 */
class SpaController extends Controller
{
    public function index(): View
    {
        $profile = Profile::current();

        return view('app', [
            'profile' => $profile,
            'meta' => $this->defaultMeta($profile),
        ]);
    }

    public function project(string $slug): View
    {
        $profile = Profile::current();
        $project = Project::query()->published()->where('slug', $slug)->first();

        if (! $project instanceof Project) {
            return view('app', [
                'profile' => $profile,
                'meta' => $this->defaultMeta($profile),
            ]);
        }

        $description = $project->summary ?: $project->tagline;

        return view('app', [
            'profile' => $profile,
            'meta' => [
                'title' => trim($project->title.' — '.($profile->name ?: 'Portfolio')),
                'description' => $this->clean($description),
                'image' => $project->cover_image_url ?: $this->ogImage($profile),
                'url' => url()->current(),
                'type' => 'article',
            ],
        ]);
    }

    /**
     * @return array<string, string|null>
     */
    private function defaultMeta(Profile $profile): array
    {
        $name = $profile->name ?: 'Portfolio';
        $title = $profile->title
            ? trim($name.' — '.$profile->title)
            : $name;

        return [
            'title' => $title,
            'description' => $this->clean($profile->headline ?: $profile->bio),
            'image' => $this->ogImage($profile),
            'url' => url()->current(),
            'type' => 'website',
        ];
    }

    private function ogImage(Profile $profile): ?string
    {
        $default = public_path('images/og-image.png');

        if (is_file($default)) {
            return asset('images/og-image.png');
        }

        return $profile->avatar_url;
    }

    private function clean(?string $text): ?string
    {
        if (blank($text)) {
            return null;
        }

        return Str::limit(trim(preg_replace('/\s+/', ' ', $text)), 200);
    }
}

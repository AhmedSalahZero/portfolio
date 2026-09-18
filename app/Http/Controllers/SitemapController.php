<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

/**
 * Generates an XML sitemap covering the landing page and every published
 * project case study, so search engines can discover all public URLs.
 */
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            [
                'loc' => url('/'),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
        ];

        Project::query()
            ->published()
            ->ordered()
            ->get(['slug', 'updated_at'])
            ->each(function (Project $project) use (&$urls): void {
                $urls[] = [
                    'loc' => url('/projects/'.$project->slug),
                    'lastmod' => optional($project->updated_at)->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                ];
            });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}

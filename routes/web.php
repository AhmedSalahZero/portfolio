<?php

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

/*
| The Vue 3 single-page application is served for every non-API route.
| Meta tags are rendered server-side (SpaController) for SEO and social
| previews; all page data is consumed from the JSON API in routes/api.php.
*/

Route::get('sitemap.xml', SitemapController::class);

Route::get('projects/{slug}', [SpaController::class, 'project']);

Route::get('/{any?}', [SpaController::class, 'index'])->where('any', '^(?!api).*$');

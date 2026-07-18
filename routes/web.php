<?php

use Illuminate\Support\Facades\Route;

/*
| The Vue 3 single-page application is served for every non-API route.
| All data is consumed from the JSON API defined in routes/api.php.
*/
Route::view('/{any?}', 'app')->where('any', '^(?!api).*$');

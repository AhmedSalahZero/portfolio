<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Portfolio') }}</title>
    <meta name="description" content="Senior Full-Stack Engineer — Laravel, Vue 3, and scalable web platforms. Selected case studies and contact.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="bg-base-950 text-slate-200 antialiased">
    <div id="app"></div>
</body>
</html>

<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
@php
    $appName = config('app.name', 'Portfolio');
    $metaTitle = $meta['title'] ?? $appName;
    $metaDescription = $meta['description'] ?? 'Senior Software Developer — Laravel, Vue 3, and scalable web platforms. Selected case studies and contact.';
    $metaImage = $meta['image'] ?? null;
    $metaUrl = $meta['url'] ?? url()->current();
    $metaType = $meta['type'] ?? 'website';
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#070a12">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:site_name" content="{{ $appName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    @if ($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="{{ $metaImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if ($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif

    {{-- Structured data: Person --}}
    @isset($profile)
        <script type="application/ld+json">
            @php
                $sameAs = array_values(array_filter([
                    $profile->github_url,
                    $profile->linkedin_url,
                    $profile->twitter_url,
                    $profile->website_url,
                ]));
                $person = array_filter([
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => $profile->name,
                    'jobTitle' => $profile->title,
                    'description' => $metaDescription,
                    'email' => $profile->email,
                    'url' => url('/'),
                    'image' => $metaImage,
                    'address' => $profile->location,
                    'sameAs' => $sameAs ?: null,
                ], fn ($value) => ! is_null($value) && $value !== '' && $value !== []);
            @endphp
            {!! json_encode($person, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endisset

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="bg-base-950 text-slate-200 antialiased">
    <div id="app"></div>
</body>
</html>

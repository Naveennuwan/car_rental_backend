<!doctype html>
<html prefix="og: http://ogp.me/ns#" lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="（★description内容）">
    <meta property="og:site_name" content="NINTY SEVEN">
    <meta property="og:title" content="NINTY SEVEN">
    <meta property="og:type" content="website">
    <meta property="og:description" content="（★description内容）">
    <meta property="og:url" content="（★サイトURL）">
    <meta property="og:image" content="（★サイトURL）img/ogp.jpg">
    <meta name="apple-mobile-web-app-title" content="NINTY SEVEN">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="NINTY SEVEN">
    <meta name="twitter:description" content="（★description内容）">

    <title>
        @if (View::hasSection('title'))
            User Management | @yield('title')
        @else
            User Management
        @endif
    </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    @include('libraries.styles')
</head>

<body>
    <div id="app">
        @include('components.nav')
        @yield('toolbar')
        <div class="container">
            @include('components.alerts')
            @yield('content')
        </div>
    </div>
    @include('libraries.scripts')
</body>

</html>

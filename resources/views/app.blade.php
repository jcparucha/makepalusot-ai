<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    @vite(['resources/js/app.ts', 'resources/css/app.css'])
</head>
<body class="dark:bg-slate-950 dark:text-white">
    <div id="app" class="h-full"></div>
</body>
</html>

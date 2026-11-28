@props(['title' => 'Foodcourt UNESA'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Foodcourt UNESA</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-surface font-sans text-ink antialiased">
    <header class="border-b border-line bg-white">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
            <x-logo href="{{ Route::has('login') ? route('login') : '/' }}" />
            <p class="text-xs text-muted">Sudah mendaftar?
                <a href="{{ Route::has('login') ? route('login') : '#' }}" class="font-bold text-navy hover:underline">Masuk</a>
            </p>
        </div>
    </header>
    <main class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        {{ $slot }}
    </main>
</body>
</html>
@props(['title' => 'Foodcourt UNESA', 'width' => 'max-w-md'])
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
<body class="min-h-screen bg-gradient-to-br from-surface via-surface to-pill font-sans text-ink antialiased">
    <main class="flex min-h-screen flex-col items-center justify-center px-4 py-10">
        <x-logo class="mb-6" />
        <div class="w-full {{ $width }} rounded-3xl bg-white p-6 shadow-[0_20px_50px_-20px_rgba(0,51,102,0.25)] ring-1 ring-line sm:p-8">
            {{ $slot }}
        </div>
    </main>
</body>
</html>
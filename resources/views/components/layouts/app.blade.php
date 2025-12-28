<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Portfolio' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 antialiased">
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(56,189,248,0.14),transparent_40%),radial-gradient(circle_at_80%_30%,rgba(99,102,241,0.18),transparent_35%),radial-gradient(circle_at_50%_80%,rgba(16,185,129,0.12),transparent_40%)]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-slate-950 to-slate-950"></div>
    </div>
    <div class="relative">
        <header class="px-6 py-8 max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center shadow-lg shadow-cyan-500/10">
                    <span class="text-lg font-semibold tracking-tight">AU</span>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Andi U.</p>
                    <p class="text-sm text-slate-200">Mobile & Web Engineer</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-4 text-sm text-slate-300">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-white transition">Tentang</a>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Available for projects
                </span>
            </nav>
        </header>

        <main class="px-6 pb-16 max-w-6xl mx-auto">
            {{ $slot }}
        </main>

        <footer class="px-6 pb-10 max-w-6xl mx-auto text-xs text-slate-500 flex items-center justify-between">
            <p>Made with Laravel 12 + TailwindCSS.</p>
            <div class="flex items-center gap-3">
                <span class="font-mono text-[11px] text-slate-400">console entry kept private</span>
            </div>
        </footer>
    </div>
</body>
</html>

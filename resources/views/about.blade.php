@php($title = 'Tentang Saya — Andi')
<x-layouts.app :title="$title">
    <section class="grid lg:grid-cols-[1.2fr,1fr] gap-10 items-start">
        <div class="relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl shadow-cyan-500/10 space-y-6">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-indigo-500/10 to-transparent pointer-events-none"></div>
            <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em]">Tentang Saya</p>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <span class="text-xl font-semibold tracking-tight">AU</span>
                </div>
                <div>
                    <h1 class="text-4xl font-semibold text-white leading-tight">Andi Utama</h1>
                    <p class="text-slate-300">Mobile & Web Engineer</p>
                </div>
            </div>
            <div class="space-y-4 text-slate-200 leading-relaxed">
                <p class="text-lg">Saya membangun produk dengan pendekatan arsitektur bersih, motion halus, dan pipeline otomatis. Fokus pada performa, kestabilan, serta dokumentasi yang bisa diandalkan tim.</p>
                <div class="grid sm:grid-cols-3 gap-3 text-sm">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Fokus</p>
                        <p class="text-white font-semibold">Performa & UX</p>
                        <p class="text-[12px] text-slate-400">Micro-interactions, smooth flow.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Stack</p>
                        <p class="text-white font-semibold">Flutter · Laravel</p>
                        <p class="text-[12px] text-slate-400">Tailwind, TS, REST/WS.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Pipeline</p>
                        <p class="text-white font-semibold">CI/CD & QA</p>
                        <p class="text-[12px] text-slate-400">Testing, linting, rollout.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($skills as $skill)
                    <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-slate-200 text-sm shadow-sm shadow-cyan-500/10">{{ $skill }}</span>
                @endforeach
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-xl shadow-indigo-500/10 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Kontak</p>
                    <h2 class="text-xl font-semibold text-white">Mari Berkolaborasi</h2>
                </div>
                <span class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-400/20 to-indigo-500/20 text-[11px] text-slate-100 border border-white/10">Fast response</span>
            </div>

            <div class="grid sm:grid-cols-2 gap-3 text-sm text-slate-200">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-2">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Email</p>
                    <p class="text-white font-semibold break-words">{{ $contact['email'] }}</p>
                    <div class="flex gap-2 text-[12px]">
                        <button type="button" class="copy-btn px-3 py-1.5 rounded-lg bg-white/10 border border-white/10 text-slate-100 hover:border-cyan-300" data-copy="{{ $contact['email'] }}">Copy</button>
                        <a href="mailto:{{ $contact['email'] }}" class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-cyan-400/20 to-indigo-500/20 border border-white/10 text-slate-100 hover:border-cyan-300">Email</a>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-2">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Telepon</p>
                    <p class="text-white font-semibold break-words">{{ $contact['phone'] }}</p>
                    <div class="flex gap-2 text-[12px]">
                        <button type="button" class="copy-btn px-3 py-1.5 rounded-lg bg-white/10 border border-white/10 text-slate-100 hover:border-cyan-300" data-copy="{{ $contact['phone'] }}">Copy</button>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $contact['phone']) }}" class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-emerald-400/20 to-cyan-500/20 border border-white/10 text-slate-100 hover:border-emerald-300" target="_blank">WhatsApp</a>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Lokasi</p>
                    <p class="text-white font-semibold">{{ $contact['location'] }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Ketersediaan</p>
                    <p class="text-emerald-200 font-semibold">{{ $contact['availability'] }}</p>
                </div>
            </div>

            <div class="h-px w-full bg-gradient-to-r from-white/30 via-white/10 to-transparent"></div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm uppercase tracking-[0.25em] text-slate-400">Riwayat Singkat</h3>
                    <span class="text-[12px] text-slate-400">Ringkasan perjalanan</span>
                </div>
                <ul class="space-y-3">
                    @foreach($timeline as $item)
                        <li class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-cyan-200">{{ $item['year'] }}</span>
                                <span class="px-2 py-1 rounded-full bg-white/10 text-[11px] text-slate-200 border border-white/10">{{ $item['title'] }}</span>
                            </div>
                            <p class="text-sm text-slate-200 leading-relaxed">{{ $item['desc'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</x-layouts.app>

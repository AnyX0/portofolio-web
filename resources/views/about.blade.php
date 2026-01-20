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
                    <h1 class="text-4xl font-semibold text-white leading-tight">{{ $name }}</h1>
                    <p class="text-slate-300">{{ $title }}</p>
                </div>
            </div>
            <div class="space-y-4 text-slate-200 leading-relaxed">
                <p class="text-lg">{{ $bio ?? 'Saya membangun produk dengan pendekatan arsitektur bersih, motion halus, dan pipeline otomatis. Fokus pada performa, kestabilan, serta dokumentasi yang bisa diandalkan tim.' }}</p>
                @if(!empty($skills))
                    <div class="grid sm:grid-cols-3 gap-3 text-sm">
                        @foreach($skills as $skill)
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                                <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">{{ $skill['type'] ?? 'Kategori' }}</p>
                                <p class="text-white font-semibold">{{ $skill['title'] ?? 'Judul' }}</p>
                                <p class="text-[12px] text-slate-400">{{ $skill['detail'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($skills as $skill)
                    <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-slate-200 text-sm shadow-sm shadow-cyan-500/10">
                        {{ $skill['title'] ?? ($skill['type'] ?? '') }}
                        @if(!empty($skill['detail']))
                            <span class="text-slate-400">— {{ $skill['detail'] }}</span>
                        @endif
                    </span>
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
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Pengalaman Kerja</h3>
                    <span class="text-[12px] text-slate-400">{{ count($timeline) }} posisi</span>
                </div>
                
                <!-- Timeline Container -->
                <div class="space-y-0 relative">
                    @foreach($timeline as $index => $item)
                        <div class="relative flex gap-6">
                            <!-- Timeline Line & Dots -->
                            <div class="absolute left-4 top-0 bottom-0 flex flex-col items-center">
                                <!-- Dot -->
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-cyan-400 to-indigo-500 border-4 border-slate-950 shadow-lg shadow-cyan-500/30 relative z-10 flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-white"></div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="pl-4 pb-8 flex-1">
                                <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-slate-900/30 p-5 hover:border-cyan-400/30 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-500/10">
                                    <!-- Header -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                                        <div>
                                            <h4 class="text-lg font-semibold text-white">{{ $item['title'] ?? 'Experience' }}</h4>
                                            <p class="text-sm text-cyan-300">{{ $item['company'] ?? 'Company' }}</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-400/30 text-xs text-cyan-200">{{ $item['type'] ?? 'Position' }}</span>
                                            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs text-slate-300">{{ $item['duration'] ?? '1 year' }}</span>
                                        </div>
                                    </div>

                                    <!-- Timeline Info -->
                                    <div class="flex items-center gap-2 mb-3 text-xs text-slate-400">
                                        <span class="font-semibold text-cyan-200">{{ $item['year'] ?? 'Year' }}</span>
                                        <span>•</span>
                                        <span>{{ $item['month'] ?? 'Month' }}</span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-slate-300 leading-relaxed mb-4">{{ $item['desc'] ?? 'Description' }}</p>

                                    <!-- Achievements -->
                                    @if(isset($item['achievements']) && count($item['achievements']) > 0)
                                        <div class="mb-4 space-y-2">
                                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-[0.15em]">Key Achievements</p>
                                            <ul class="space-y-1.5">
                                                @foreach($item['achievements'] as $achievement)
                                                    <li class="flex gap-2 text-xs text-slate-300">
                                                        <span class="text-cyan-400 mt-1 flex-shrink-0">▪</span>
                                                        <span>{{ $achievement }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Skills Used -->
                                    @if(isset($item['skills']) && count($item['skills']) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item['skills'] as $skill)
                                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-[11px] text-slate-300 hover:border-cyan-400/30 transition-colors">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>

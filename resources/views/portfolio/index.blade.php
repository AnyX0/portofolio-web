@php
    $title = 'Portfolio — Andi';
@endphp
<x-layouts.app :title="$title">
    <section class="relative grid lg:grid-cols-[1.4fr,1fr] gap-8 items-start">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 w-[40vw] h-[40vw] rounded-full bg-gradient-to-br from-fuchsia-500/20 via-rose-400/10 to-amber-400/20 blur-3xl animate-pulse"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -right-24 w-[35vw] h-[35vw] rounded-full bg-gradient-to-tr from-sky-500/20 via-indigo-400/10 to-violet-500/20 blur-3xl animate-pulse"></div>
        <div class="relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl shadow-cyan-500/15 space-y-6">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_10%_10%,rgba(56,189,248,0.16),transparent_40%),radial-gradient(circle_at_80%_20%,rgba(99,102,241,0.18),transparent_35%)]"></div>
            <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em]">Featured Work</p>
            <h1 class="text-4xl lg:text-5xl font-semibold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-pink-400 to-sky-400">Portofolio kompleks, elegan,
                siap produksi.</h1>
            <p class="text-lg text-slate-200 leading-relaxed">Mobile & web apps dengan arsitektur bersih, motion halus,
                dan pipeline yang solid. Fokus pada performa, keamanan, dan pengalaman pengguna yang konsisten.</p>
            <div class="flex flex-wrap gap-3">
                <span class="px-4 py-2 rounded-full bg-emerald-400/10 text-emerald-200 text-sm border border-emerald-400/30">Flutter</span>
                <span class="px-4 py-2 rounded-full bg-indigo-400/10 text-indigo-200 text-sm border border-indigo-400/30">Laravel</span>
                <span class="px-4 py-2 rounded-full bg-cyan-400/10 text-cyan-100 text-sm border border-cyan-400/30">Tailwind</span>
                <span class="px-4 py-2 rounded-full bg-amber-400/10 text-amber-100 text-sm border border-amber-400/30">Clean Architecture</span>
            </div>
            <div class="grid sm:grid-cols-3 gap-3 text-sm text-slate-200">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-0.5 hover:shadow-xl">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Deploy</p>
                    <p class="text-white font-semibold">Zero-downtime</p>
                    <p class="text-[12px] text-slate-400">GitHub Actions, blue/green.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-0.5 hover:shadow-xl">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Quality</p>
                    <p class="text-white font-semibold">Tested</p>
                    <p class="text-[12px] text-slate-400">Unit + lint + audit.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-0.5 hover:shadow-xl">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Security</p>
                    <p class="text-white font-semibold">Session guard</p>
                    <p class="text-[12px] text-slate-400">HSTS, rate-limit.</p>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-xl shadow-indigo-500/10 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Ringkasan</p>
                    <p class="text-lg text-white font-semibold">Delivery siap pakai</p>
                </div>
                <div class="px-3 py-1 rounded-full bg-white/10 text-[11px] text-slate-200 border border-white/10">Realtime ready</div>
            </div>
            <ul class="space-y-3 text-sm text-slate-200">
                <li class="flex items-center justify-between"><span>CI/CD</span><span class="text-emerald-300">GitHub Actions</span></li>
                <li class="flex items-center justify-between"><span>Infra</span><span class="text-indigo-200">Laravel + Vite</span></li>
                <li class="flex items-center justify-between"><span>Design DNA</span><span class="text-cyan-200">Gradients + motion</span></li>
                <li class="flex items-center justify-between"><span>Security</span><span class="text-amber-200">Session guard</span></li>
            </ul>
            <div class="grid sm:grid-cols-2 gap-3 text-[12px] text-slate-300">
                <div class="rounded-xl border border-white/10 bg-white/5 p-3 transition hover:-translate-y-0.5">Best for SaaS dashboards, multi-tenant.</div>
                <div class="rounded-xl border border-white/10 bg-white/5 p-3 transition hover:-translate-y-0.5">Ideal untuk fintech, billing, atau katalog.</div>
            </div>
        </div>
    </section>

    <section class="mt-12 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-white">Project</h2>
            <div class="h-px flex-1 ml-4 bg-gradient-to-r from-white/30 via-white/10 to-transparent"></div>
        </div>

        @if($projects->isEmpty())
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-slate-300">Belum ada project. Login admin untuk menambah.</div>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    @php
                        $projectImages = $allProjectImages[$project->id] ?? [];
                    @endphp
                    <a href="{{ route('project.show', $project->slug) }}" class="group relative rounded-3xl border border-white/10 bg-white/5 overflow-hidden shadow-lg shadow-black/20 transition hover:-translate-y-0.5 hover:shadow-xl hover:border-white/20 flex flex-col">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-transparent to-indigo-500/10 opacity-0 group-hover:opacity-100 transition duration-500 pointer-events-none z-10"></div>
                        
                        @if(!empty($projectImages))
                            <div class="relative h-48 bg-slate-900/50 overflow-hidden">
                                <div class="swiper-container h-full project-slider-{{ $loop->index }}">
                                    <div class="swiper-wrapper">
                                        @foreach($projectImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="p-6 flex flex-col gap-4 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ optional($project->published_at)->format('M Y') ?? 'Draft' }}</p>
                                <span class="px-3 py-1 rounded-full text-[11px] border {{ $project->is_published ? 'border-emerald-400/40 text-emerald-200 bg-emerald-400/10' : 'border-amber-400/40 text-amber-200 bg-amber-400/10' }}">
                                    {{ $project->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-semibold text-white leading-tight">{{ $project->title }}</h3>
                            <p class="text-sm text-slate-300 leading-relaxed line-clamp-3">{{ $project->summary }}</p>
                            
                            @if($project->tech_stack)
                                <div class="flex flex-wrap gap-2 text-[12px]">
                                    @foreach(explode(',', $project->tech_stack) as $tech)
                                        <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-2 text-sm text-cyan-200 mt-auto pt-2 transition-all duration-300 group-hover:text-cyan-100">
                                <span class="group-hover:translate-x-1 transition">Lihat detail</span>
                                <span class="group-hover:translate-x-1 transition">→</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($projects as $project)
                @php
                    $projectImages = [];
                    if ($project->cloudinary_folder) {
                        $fetcher = new \App\Services\CloudinaryImageFetcher();
                        $projectImages = $fetcher->getImagesFromFolder($project->cloudinary_folder);
                    }
                @endphp
                @if(!empty($projectImages) && count($projectImages) > 1)
                    new Swiper('.project-slider-{{ $loop->index }}', {
                        loop: true,
                        autoplay: { 
                            delay: 3000,
                            disableOnInteraction: false 
                        },
                        effect: 'fade',
                        fadeEffect: { 
                            crossFade: true 
                        },
                        speed: 800,
                    });
                @endif
            @endforeach
        });
    </script>
</x-layouts.app>

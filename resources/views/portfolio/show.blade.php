@php
    $title = $project->title.' — Case Study';
@endphp
<x-layouts.app :title="$title">
    <div class="relative grid lg:grid-cols-[1.6fr,1fr] gap-10">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 w-[35vw] h-[35vw] rounded-full bg-gradient-to-br from-fuchsia-500/20 via-rose-400/10 to-amber-400/20 blur-3xl animate-pulse"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -right-24 w-[30vw] h-[30vw] rounded-full bg-gradient-to-tr from-sky-500/20 via-indigo-400/10 to-violet-500/20 blur-3xl animate-pulse"></div>
        <div class="space-y-6">
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/30">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-transparent to-indigo-500/10 pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-4 text-sm text-slate-400">
                    <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[11px] uppercase tracking-[0.2em]">{{ $project->is_published ? 'Published' : 'Draft' }}</span>
                    <span>•</span>
                    <span>{{ optional($project->published_at)->format('d M Y') ?? 'Draft mode' }}</span>
                </div>
                <h1 class="text-4xl font-semibold leading-tight mb-3 bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-pink-400 to-sky-400">{{ $project->title }}</h1>
                <p class="text-lg text-slate-200 leading-relaxed mb-4">{{ $project->summary }}</p>
                
                @if($project->tech_stack)
                    <div class="flex flex-wrap gap-2 text-[12px]">
                        @foreach(explode(',', $project->tech_stack) as $tech)
                            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                @endif

                @if(!empty($images))
                    <div class="mt-6 -mx-8 -mb-8 overflow-hidden rounded-b-3xl">
                        <div class="relative h-80 bg-slate-900/50">
                            <div class="swiper h-full" id="projectSlider">
                                <div class="swiper-wrapper">
                                    @foreach($images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image }}" alt="Project image" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if($project->description)
                <div class="rounded-3xl border border-white/10 bg-white/5 p-8 prose prose-invert max-w-none prose-headings:text-white prose-a:text-cyan-300">
                    {!! nl2br(e($project->description)) !!}
                </div>
            @endif
        </div>

        <aside class="space-y-4">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 space-y-3 transition hover:-translate-y-0.5 hover:shadow-xl">
                <h2 class="text-lg font-semibold text-white">Informasi</h2>
                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <dt>Stack</dt>
                        <dd class="text-right">{{ $project->tech_stack ?? 'TBD' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <dt>Status</dt>
                        <dd class="text-right">{{ $project->is_published ? 'Live' : 'Draft' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <dt>Diterbitkan</dt>
                        <dd class="text-right">{{ optional($project->published_at)->format('d M Y') ?? 'Belum' }}</dd>
                    </div>
                </dl>
                <div class="grid grid-cols-2 gap-2 text-[12px] text-slate-300">
                    <div class="rounded-xl border border-white/10 bg-white/5 p-3 transition hover:-translate-y-0.5">Scope jelas, dokumentasi rapi.</div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-3 transition hover:-translate-y-0.5">Siap scale dengan modular code.</div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 flex flex-col gap-3 text-sm text-slate-200">
                @if($project->live_url)
                    <a href="{{ $project->live_url }}" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-emerald-400/10 border border-emerald-400/30 text-emerald-100 hover:bg-emerald-400/15 transition" target="_blank">
                        <span>Open Live</span>
                        <span>↗</span>
                    </a>
                @endif
                @if($project->repo_url)
                    <a href="{{ $project->repo_url }}" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-white/5 border border-white/10 hover:border-white/30 transition" target="_blank">
                        <span>Source Code</span>
                        <span>↗</span>
                    </a>
                @endif
                <a href="{{ route('home') }}" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-white/5 border border-white/10 hover:border-white/30 transition">
                    <span>Kembali</span>
                    <span>←</span>
                </a>
            </div>
        </aside>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiperElement = document.querySelector('#projectSlider');
            if (swiperElement) {
                const slides = swiperElement.querySelectorAll('.swiper-slide');
                if (slides.length > 0) {
                    new Swiper('#projectSlider', {
                        loop: slides.length > 1,
                        autoplay: slides.length > 1 ? { 
                            delay: 4000, 
                            disableOnInteraction: false 
                        } : false,
                        effect: 'fade',
                        fadeEffect: { crossFade: true },
                        speed: 800,
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                    });
                }
            }
        });
    </script>
</x-layouts.app>

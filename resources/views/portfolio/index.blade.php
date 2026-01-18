@php
    $title = 'Projects — Andi';
@endphp
<x-layouts.app :title="$title">
    <!-- Page Header -->
    <section class="py-12 space-y-6">
        <div class="text-center space-y-4">
            <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em]">My Work</p>
            <h1 class="text-4xl lg:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-pink-400 to-sky-400">
                Projects Portfolio
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                Koleksi project yang sudah saya kerjakan. Dari mobile apps hingga web applications dengan teknologi modern.
            </p>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-12 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-white">Projects</h2>
            <div class="h-px flex-1 ml-4 bg-gradient-to-r from-white/30 via-white/10 to-transparent"></div>
        </div>

        @if($projects->isEmpty())
            <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-slate-300">Belum ada project. Login admin untuk menambah.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    @php
                        $projectImages = $allProjectImages[$project->id] ?? [];
                    @endphp
                    <div class="group relative rounded-3xl border border-white/10 bg-white/5 overflow-hidden shadow-lg shadow-black/20 transition hover:-translate-y-1 hover:shadow-2xl hover:border-white/20 flex flex-col">
                        <!-- Hover Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-transparent to-indigo-500/10 opacity-0 group-hover:opacity-100 transition duration-500 pointer-events-none"></div>
                        
                        <!-- Project Image Slider -->
                        @if(!empty($projectImages))
                            <div class="relative h-48 bg-slate-900/50 overflow-hidden">
                                <div class="swiper h-full project-slider-{{ $loop->index }}">
                                    <div class="swiper-wrapper">
                                        @foreach($projectImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image }}" alt="{{ $project->title }}" class="w-full h-full object-cover pointer-events-none">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center pointer-events-none">
                                <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Project Info -->
                        <div class="relative p-6 flex flex-col gap-4 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">
                                    {{ optional($project->published_at)->format('M Y') ?? 'Draft' }}
                                </p>
                                <span class="px-3 py-1 rounded-full text-[11px] font-medium border {{ $project->is_published ? 'border-emerald-400/40 text-emerald-200 bg-emerald-400/10' : 'border-amber-400/40 text-amber-200 bg-amber-400/10' }}">
                                    {{ $project->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            
                            <a href="{{ route('project.show', $project->slug) }}" class="text-xl font-semibold text-white leading-tight group-hover:text-cyan-300 transition hover:underline">
                                {{ $project->title }}
                            </a>
                            
                            <p class="text-sm text-slate-300 leading-relaxed line-clamp-3">
                                {{ $project->summary }}
                            </p>
                            
                            @if($project->tech_stack)
                                <div class="flex flex-wrap gap-2 text-[11px]">
                                    @foreach(explode(',', $project->tech_stack) as $tech)
                                        <span class="px-2 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200">
                                            {{ trim($tech) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-2 text-sm text-cyan-400 mt-auto pt-2 transition-all duration-300 group-hover:gap-3">
                                <a href="{{ route('project.show', $project->slug) }}" class="flex-1 hover:underline">Lihat detail</a>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($projects as $project)
                @php
                    $projectImages = $allProjectImages[$project->id] ?? [];
                @endphp
                @if(!empty($projectImages) && count($projectImages) > 1)
                    new Swiper('.project-slider-{{ $loop->index }}', {
                        loop: true,
                        autoplay: { 
                            delay: 3500,
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

@php
    $title = $project->title.' — Case Study';
@endphp
<x-layouts.app :title="$title">
    <div class="relative grid lg:grid-cols-[1.6fr,1fr] gap-10">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 w-[35vw] h-[35vw] rounded-full bg-gradient-to-br from-fuchsia-500/20 via-rose-400/10 to-amber-400/20 blur-3xl animate-pulse"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -right-24 w-[30vw] h-[30vw] rounded-full bg-gradient-to-tr from-sky-500/20 via-indigo-400/10 to-violet-500/20 blur-3xl animate-pulse"></div>
        
        <div class="space-y-6">
            <!-- Project Header Card -->
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-2xl shadow-black/30">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-transparent to-indigo-500/10 pointer-events-none z-0"></div>
                
                <div class="relative p-8 z-10">
                    <div class="flex items-center gap-3 mb-4 text-sm text-slate-400">
                        <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[11px] uppercase tracking-[0.2em]">
                            {{ $project->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <span>•</span>
                        <span>{{ optional($project->published_at)->format('d M Y') ?? 'Draft mode' }}</span>
                    </div>
                    
                    <h1 class="text-4xl font-semibold leading-tight mb-3 bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-pink-400 to-sky-400">
                        {{ $project->title }}
                    </h1>
                    
                    <p class="text-lg text-slate-200 leading-relaxed mb-4">
                        {{ $project->summary }}
                    </p>
                    
                    @if($project->tech_stack)
                        <div class="flex flex-wrap gap-2 text-[12px]">
                            @foreach(explode(',', $project->tech_stack) as $tech)
                                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200">
                                    {{ trim($tech) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(!empty($images) && count($images) > 0)
                    <div class="w-full h-full md:h-64 lg:h-72 bg-slate-900/50 border-t border-white/5 overflow-hidden relative">
                        <div class="swiper projectSlider w-full h-full" id="projectSlider">
                            <div class="swiper-wrapper h-full w-full">
                                @foreach($images as $image)
                                    <div class="swiper-slide w-full h-full">
                                        <img src="{{ $image }}" alt="Project image" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                @endif
            </div>

            @if($project->description)
                <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 shadow-lg">
                    <div class="prose prose-invert max-w-none prose-headings:text-white prose-a:text-cyan-300 prose-p:text-slate-200">
                        {!! nl2br(e($project->description)) !!}
                    </div>
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
                    <a href="{{ $project->live_url }}" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-emerald-400/10 border border-emerald-400/30 text-emerald-100 hover:bg-emerald-400/15 transition" target="_blank" rel="noopener noreferrer">
                        <span>Open Live</span>
                        <span>↗</span>
                    </a>
                @endif
                @if($project->repo_url)
                    <a href="{{ $project->repo_url }}" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-white/5 border border-white/10 hover:border-white/30 transition" target="_blank" rel="noopener noreferrer">
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
        const initSwiper = () => {
            const swiperElement = document.querySelector('.projectSlider');
            if (!swiperElement) {
                console.error('Swiper element not found');
                return;
            }

            const slides = swiperElement.querySelectorAll('.swiper-slide');
            console.log('Total slides found:', slides.length);

            if (slides.length === 0) {
                console.warn('No slides found in swiper');
                return;
            }

            try {
                const swiper = new Swiper('.projectSlider', {
                    loop: slides.length > 1,
                    autoplay: slides.length > 1 ? {
                        delay: 4000,
                        disableOnInteraction: false
                    } : false,
                    speed: 800,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
                console.log('Swiper initialized successfully');
            } catch (error) {
                console.error('Error initializing swiper:', error);
            }
        };

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSwiper);
        } else {
            initSwiper();
        }
    </script>

    <style>
        .projectSlider {
            width: 100%;
            height: 100%;
            display: flex;
            --swiper-navigation-size: 24px;
        }

        .swiper-wrapper {
            width: 100% !important;
            height: 100% !important;
        }

        .swiper-slide {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            margin: 0;
            padding: 0;
        }

        .swiper-button-next,
        .swiper-button-prev {
            background: rgba(0, 0, 0, 0.5);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 16px;
            color: white;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .swiper-pagination {
            bottom: 8px !important;
            z-index: 20;
        }

        .swiper-pagination-bullet {
            background: white;
            opacity: 0.4;
            margin: 0 4px;
            width: 8px;
            height: 8px;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
        }
    </style>
</x-layouts.app>

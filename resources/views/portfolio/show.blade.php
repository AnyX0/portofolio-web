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
                    <button onclick="openProjectPreview('{{ $project->slug }}', '{{ addslashes($project->title) }}', '{{ addslashes($project->summary) }}', '{{ $project->live_url ?? '#' }}', '{{ $project->is_published }}')" class="inline-flex items-center justify-between px-4 py-3 rounded-2xl bg-emerald-400/10 border border-emerald-400/30 text-emerald-100 hover:bg-emerald-400/15 transition cursor-pointer">
                        <span>Open Live</span>
                        <span>↗</span>
                    </button>
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

    <!-- Project Preview Modal -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeProjectPreview()"></div>
        
        <!-- Modal Content -->
        <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
            <div class="relative bg-gradient-to-br from-slate-900/95 to-slate-950/95 border border-white/10 rounded-3xl shadow-2xl shadow-black/50 max-w-2xl w-full my-8" onclick="event.stopPropagation()">
                <!-- Close Button -->
                <button onclick="closeProjectPreview()" class="absolute top-4 right-4 z-10 p-2 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-8 space-y-6">
                    <!-- Title -->
                    <div>
                        <h2 id="previewTitle" class="text-3xl font-bold text-white mb-2"></h2>
                        <p id="previewStatus" class="inline-block px-3 py-1 rounded-full text-xs font-medium border"></p>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-2">Deskripsi</h3>
                        <p id="previewSummary" class="text-slate-300 leading-relaxed"></p>
                    </div>

                    <!-- Live Preview -->
                    <div id="previewIframeContainer" class="rounded-xl overflow-hidden border border-white/10 bg-black/40 max-h-[720px]">
                        <div class="p-4 text-slate-300 text-sm">Memuat live preview…</div>
                    </div>

                    <!-- Project Details Loading -->
                    <div id="previewDetails" class="space-y-4">
                        <div class="animate-pulse space-y-4">
                            <div class="h-4 bg-white/10 rounded w-3/4"></div>
                            <div class="h-4 bg-white/10 rounded w-1/2"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-white/10">
                        <a id="previewLink" href="#" target="_blank" class="flex-1 px-4 py-3 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-medium text-center transition">
                            Kunjungi Project
                        </a>
                        <button onclick="closeProjectPreview()" class="flex-1 px-4 py-3 rounded-lg bg-white/10 hover:bg-white/20 text-white font-medium transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function openProjectPreview(projectSlug, title, summary, link, isPublished) {
            const modal = document.getElementById('previewModal');
            const titleEl = document.getElementById('previewTitle');
            const statusEl = document.getElementById('previewStatus');
            const summaryEl = document.getElementById('previewSummary');
            const detailsEl = document.getElementById('previewDetails');
            const linkEl = document.getElementById('previewLink');
            const iframeContainer = document.getElementById('previewIframeContainer');

            // Set basic info
            titleEl.textContent = title;
            summaryEl.textContent = summary;
            linkEl.href = link || '#';
            
            // Set status badge
            if (isPublished === '1' || isPublished === true) {
                statusEl.className = 'inline-block px-3 py-1 rounded-full text-xs font-medium border border-emerald-400/40 text-emerald-200 bg-emerald-400/10';
                statusEl.textContent = 'Published';
            } else {
                statusEl.className = 'inline-block px-3 py-1 rounded-full text-xs font-medium border border-amber-400/40 text-amber-200 bg-amber-400/10';
                statusEl.textContent = 'Draft';
            }

            // Determine preview URL and render iframe (fallback to provided link)
            let previewUrl = link && link !== '#' ? link : null;

            // Fetch detailed project info by slug
            try {
                const response = await fetch(`/api/projects/slug/${projectSlug}`);
                let data;
                try {
                    data = await response.json();
                } catch (_) {
                    data = null;
                }
                if (!response.ok) {
                    const errMsg = (data && (data.error || data.message)) ? (data.error || data.message) : 'Gagal mengambil data project';
                    throw new Error(errMsg);
                }

                // Prefer live_url from API if available
                if (data.live_url) {
                    previewUrl = data.live_url;
                    linkEl.href = data.live_url;
                }
                
                // Build details HTML
                let detailsHTML = '';

                if (data.tech_stack) {
                    const techs = data.tech_stack.split(',').map(t => `<span class="px-2 py-1 rounded-full bg-white/5 border border-white/10 text-slate-200 text-xs">${t.trim()}</span>`).join('');
                    detailsHTML += `
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 mb-2">Tech Stack</h3>
                            <div class="flex flex-wrap gap-2">${techs}</div>
                        </div>
                    `;
                }

                if (data.description) {
                    detailsHTML += `
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 mb-2">Detail Lengkap</h3>
                            <p class="text-slate-300 text-sm leading-relaxed">${data.description}</p>
                        </div>
                    `;
                }


                detailsEl.innerHTML = detailsHTML || '<p class="text-slate-400">Data lengkap tidak tersedia</p>';
            } catch (error) {
                console.error('Error fetching project:', error);
                detailsEl.innerHTML = `<p class="text-red-400">${error.message}</p>`;
            }

            // Render iframe preview
            iframeContainer.innerHTML = '';
            if (previewUrl && /^https?:\/\//.test(previewUrl)) {
                const iframe = document.createElement('iframe');
                iframe.src = previewUrl;
                iframe.className = 'w-full h-[720px] bg-black';
                iframe.style.transform = 'scale(0.8)';
                iframe.style.transformOrigin = 'top left';
                iframe.style.width = '125%';
                iframe.style.height = '900px';
                iframe.referrerPolicy = 'no-referrer';
                iframe.allow = 'fullscreen';
                iframe.sandbox = 'allow-scripts allow-same-origin allow-forms allow-popups';
                iframeContainer.appendChild(iframe);

                // Fallback notice if the site blocks embedding
                const notice = document.createElement('div');
                notice.className = 'p-3 text-xs text-slate-400 border-t border-white/10';
                notice.textContent = 'Catatan: Beberapa situs mungkin memblokir embed (X-Frame-Options).';
                iframeContainer.appendChild(notice);
            } else {
                iframeContainer.innerHTML = '<div class="p-4 text-slate-300 text-sm">Live preview tidak tersedia untuk URL ini.</div>';
            }

            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeProjectPreview() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeProjectPreview();
            }
        });
    </script>
</x-layouts.app>

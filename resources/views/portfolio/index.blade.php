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
                    <div class="group relative rounded-3xl border border-white/10 bg-white/5 overflow-hidden shadow-lg shadow-black/20 transition hover:-translate-y-1 hover:shadow-2xl hover:border-white/20 flex flex-col cursor-pointer" onclick="openProjectPreview({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ addslashes($project->summary) }}', '{{ $project->link ?? '#' }}', '{{ $project->is_published }}')">
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
                            
                            <h3 class="text-xl font-semibold text-white leading-tight group-hover:text-cyan-300 transition">
                                {{ $project->title }}
                            </h3>
                            
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
                                <span>Lihat detail</span>
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
        async function openProjectPreview(projectId, title, summary, link, isPublished) {
            const modal = document.getElementById('previewModal');
            const titleEl = document.getElementById('previewTitle');
            const statusEl = document.getElementById('previewStatus');
            const summaryEl = document.getElementById('previewSummary');
            const detailsEl = document.getElementById('previewDetails');
            const linkEl = document.getElementById('previewLink');

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

            // Fetch detailed project info
            try {
                const response = await fetch(`/api/projects/${projectId}`);
                if (!response.ok) throw new Error('Failed to fetch');
                
                const data = await response.json();
                
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

                if (data.client) {
                    detailsHTML += `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Client</p>
                                <p class="text-slate-200 font-medium">${data.client}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Tipe Project</p>
                                <p class="text-slate-200 font-medium">${data.project_type || 'N/A'}</p>
                            </div>
                        </div>
                    `;
                }

                detailsEl.innerHTML = detailsHTML || '<p class="text-slate-400">Data lengkap tidak tersedia</p>';
            } catch (error) {
                console.error('Error fetching project:', error);
                detailsEl.innerHTML = '<p class="text-red-400">Gagal memuat detail project</p>';
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

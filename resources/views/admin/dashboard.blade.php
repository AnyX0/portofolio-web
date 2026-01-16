<x-layouts.app title="Console">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Console</p>
            <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-lg bg-white/10 border border-white/10 text-sm text-slate-200 hover:bg-white/15">Keluar</button>
        </form>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/10 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Total Project</p>
                    <p class="text-3xl font-semibold text-white">{{ $totalCount }}</p>
                </div>
                <svg class="w-12 h-12 text-cyan-400/20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V4zm12 12H5V4h10v12z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-6 hover:bg-emerald-500/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Published</p>
                    <p class="text-3xl font-semibold text-emerald-300">{{ $publishedCount }}</p>
                </div>
                <svg class="w-12 h-12 text-emerald-400/20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <div class="rounded-2xl border border-amber-400/20 bg-amber-500/10 p-6 hover:bg-amber-500/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Draft</p>
                    <p class="text-3xl font-semibold text-amber-200">{{ $draftCount }}</p>
                </div>
                <svg class="w-12 h-12 text-amber-400/20" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
            </div>
        </div>
        <div class="rounded-2xl border border-indigo-400/20 bg-indigo-500/10 p-6 hover:bg-indigo-500/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-1">7 Hari Terakhir</p>
                    <p class="text-3xl font-semibold text-indigo-300">{{ $recentCount }}</p>
                </div>
                <svg class="w-12 h-12 text-indigo-400/20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('admin.projects.index') }}" class="p-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-cyan-400/40 transition group">
                <div class="flex items-center gap-4">
                    <svg class="w-12 h-12 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <div>
                        <h3 class="font-semibold text-white">Kelola Project</h3>
                        <p class="text-sm text-slate-400">Lihat & edit semua project</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 ml-auto group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            <a href="{{ route('admin.projects.create') }}" class="p-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-emerald-400/40 transition group">
                <div class="flex items-center gap-4">
                    <svg class="w-12 h-12 text-emerald-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <div>
                        <h3 class="font-semibold text-white">Project Baru</h3>
                        <p class="text-sm text-slate-400">Buat project portfolio baru</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 ml-auto group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Projects -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-white">Project Terbaru</h2>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-cyan-300 hover:text-cyan-200">Lihat Semua →</a>
        </div>
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur">
            <table class="min-w-full text-sm text-slate-200">
                <thead class="bg-white/5">
                    <tr>
                        <th class="text-left px-4 py-3">Judul</th>
                        <th class="text-center px-4 py-3">Status</th>
                        <th class="text-center px-4 py-3">Dibuat</th>
                        <th class="text-center px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($projects->take(5) as $project)
                    <tr class="border-t border-white/5 hover:bg-white/5 transition">
                        <td class="px-4 py-3 font-medium text-white">{{ $project->title }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($project->is_published)
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300">Published</span>
                            @else
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">{{ $project->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 rounded-lg hover:bg-amber-500/10 text-amber-400 hover:text-amber-300 transition-all group" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <!-- Archive -->
                                <button onclick="archiveProject({{ $project->id }})" class="p-2 rounded-lg hover:bg-blue-500/10 text-blue-400 hover:text-blue-300 transition-all group" title="Arsipkan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                </button>
                                
                                <!-- Share -->
                                <button onclick="shareProject({{ $project->id }}, '{{ $project->title }}')" class="p-2 rounded-lg hover:bg-indigo-500/10 text-indigo-400 hover:text-indigo-300 transition-all group" title="Bagikan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                </button>
                                
                                <!-- Delete -->
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline delete-form-{{ $project->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" title="Hapus" onclick="deleteProject('{{ $project->id }}', document.querySelector('.deleteForm-{{ $project->id }}'))" class="p-2 rounded-lg hover:bg-rose-500/10 text-rose-400 hover:text-rose-300 transition-all group">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-4 text-center text-slate-400">Belum ada project.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>

 <x-layouts.app title="Daftar Project">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Console</p>
            <h1 class="text-2xl font-semibold text-white">Daftar Project</h1>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-gradient-to-r from-cyan-400 to-indigo-500 text-slate-950 font-semibold text-sm shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Project
        </a>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid md:grid-cols-4 gap-3 mb-6">
        <div class="rounded-lg border border-white/10 bg-white/5 p-3">
            <p class="text-xs text-slate-400 mb-1">Total</p>
            <p class="text-xl font-semibold text-white">{{ $totalCount }}</p>
        </div>
        <div class="rounded-lg border border-emerald-400/20 bg-emerald-500/10 p-3">
            <p class="text-xs text-slate-400 mb-1">Published</p>
            <p class="text-xl font-semibold text-emerald-300">{{ $publishedCount }}</p>
        </div>
        <div class="rounded-lg border border-amber-400/20 bg-amber-500/10 p-3">
            <p class="text-xs text-slate-400 mb-1">Draft</p>
            <p class="text-xl font-semibold text-amber-200">{{ $draftCount }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-white/5 p-3">
            <p class="text-xs text-slate-400 mb-1">Recent</p>
            <p class="text-xl font-semibold text-cyan-300">{{ $recentCount }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-lg text-sm {{ !request('status') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5' }}">Semua</a>
            <a href="{{ route('admin.projects.index', ['status' => 'published']) }}" class="px-3 py-2 rounded-lg text-sm {{ request('status') === 'published' ? 'bg-emerald-500/20 text-emerald-300' : 'text-slate-400 hover:bg-white/5' }}">Published</a>
            <a href="{{ route('admin.projects.index', ['status' => 'draft']) }}" class="px-3 py-2 rounded-lg text-sm {{ request('status') === 'draft' ? 'bg-amber-500/20 text-amber-300' : 'text-slate-400 hover:bg-white/5' }}">Draft</a>
        </div>
        <a href="{{ route('admin.projects.archived') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-white/5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Lihat Arsip
        </a>
    </div>

    <!-- Projects Table -->
    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-200">
                <thead class="bg-white/5 sticky top-0">
                    <tr>
                        <th class="text-left px-4 py-3">
                            <a href="{{ route('admin.projects.index', array_merge(request()->query(), ['sort' => 'title'])) }}" class="hover:text-white">Judul</a>
                        </th>
                        <th class="text-left px-4 py-3">Tech Stack</th>
                        <th class="text-center px-4 py-3">Status</th>
                        <th class="text-center px-4 py-3">
                            <a href="{{ route('admin.projects.index', array_merge(request()->query(), ['sort' => 'published_at'])) }}" class="hover:text-white">Dipublikasikan</a>
                        </th>
                        <th class="text-center px-4 py-3">Dibuat</th>
                        <th class="text-center px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($projects as $project)
                    <tr class="border-t border-white/5 hover:bg-white/5 transition">
                        <td class="px-4 py-3 font-medium text-white max-w-xs">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="hover:text-cyan-300 truncate block">{{ $project->title }}</a>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            @if($project->tech_stack)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(explode(',', $project->tech_stack) as $tech)
                                        <span class="px-2 py-1 rounded bg-indigo-500/20 text-indigo-300">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($project->is_published)
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300">Published</span>
                            @else
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            {{ optional($project->published_at)->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            {{ $project->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex items-center justify-center gap-2 bg-white/5 rounded-lg p-1">
                                <!-- Edit -->
                                <a href="{{ route('admin.projects.edit', $project) }}" title="Edit" class="inline-flex items-center justify-center w-8 h-8 rounded text-amber-400 hover:bg-amber-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                
                                <!-- Archive -->
                                <button type="button" onclick="AdminProjects.archiveProject('{{ $project->id }}')" title="Arsipkan" class="inline-flex items-center justify-center w-8 h-8 rounded text-blue-400 hover:bg-blue-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </button>
                                
                                <!-- Share -->
                                <button type="button" onclick="AdminProjects.shareProject('{{ $project->id }}')" title="Bagikan" class="inline-flex items-center justify-center w-8 h-8 rounded text-indigo-400 hover:bg-indigo-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C9.589 12.938 10 12.502 10 12c0-.502-.411-.938-1.316-1.342m0 2.684a3 3 0 110-2.684m9.032-6.348a3 3 0 110 4.243m0-4.243L9.758 19.242a3 3 0 11-4.243-4.243l12.159-12.159z"/></svg>
                                </button>
                                
                                <!-- Delete -->
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline deleteForm-{{ $project->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" title="Hapus" onclick="AdminProjects.deleteProject('{{ $project->id }}', document.querySelector('.deleteForm-{{ $project->id }}'))" class="inline-flex items-center justify-center w-8 h-8 rounded text-rose-400 hover:bg-rose-500/20 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Belum ada project{{ request('status') ? ' dengan status ini' : '' }}.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $projects->links() }}
    </div>

    <div class="mt-6 flex items-center gap-2 text-sm text-slate-400">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/></svg>
        Menampilkan {{ $projects->count() }} dari {{ $projects->total() }} project
    </div>

    <!-- Modal Archive -->
    <div id="archiveModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-2xl border border-white/10 max-w-sm w-full p-6 animate-in fade-in">
            <h3 class="text-lg font-semibold text-white mb-2">Arsipkan Project</h3>
            <p class="text-slate-300 mb-6">Apakah Anda yakin ingin mengarsipkan project ini? Data akan tetap tersimpan.</p>
            <div class="flex gap-3">
                <button onclick="AdminProjects.closeModal('archiveModal')" class="flex-1 px-4 py-2 rounded-lg bg-slate-700 text-slate-200 hover:bg-slate-600 transition">Batal</button>
                <button onclick="AdminProjects.confirmArchive()" class="flex-1 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Arsipkan</button>
            </div>
        </div>
    </div>

    <!-- Modal Share -->
    <div id="shareModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-2xl border border-white/10 max-w-sm w-full p-6 animate-in fade-in">
            <h3 class="text-lg font-semibold text-white mb-2">Bagikan Project</h3>
            <p class="text-slate-300 mb-4">Salin link project ini untuk dibagikan:</p>
            <input type="text" id="shareUrl" data-share-base="{{ url('/project') }}" readonly class="w-full px-3 py-2 rounded-lg bg-slate-700 text-slate-200 border border-white/10 text-sm mb-4">
            <div class="flex gap-3">
                <button onclick="AdminProjects.closeModal('shareModal')" class="flex-1 px-4 py-2 rounded-lg bg-slate-700 text-slate-200 hover:bg-slate-600 transition">Tutup</button>
                <button onclick="AdminProjects.copyShareLink()" class="flex-1 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Salin</button>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-slate-800 rounded-2xl border border-white/10 max-w-sm w-full p-6 animate-in fade-in">
            <h3 class="text-lg font-semibold text-white mb-2">Hapus Project</h3>
            <p class="text-slate-300 mb-4"><span class="text-rose-400 font-semibold">Perhatian!</span> Tindakan ini tidak dapat dibatalkan. Semua data project akan dihapus secara permanen.</p>
            <p class="text-sm text-slate-400 mb-4">Ketik <span class="text-white font-semibold">Hapus</span> untuk mengkonfirmasi:</p>
            <input type="text" id="deleteConfirmInput" placeholder="Ketik 'Hapus' di sini" class="w-full px-3 py-2 rounded-lg bg-slate-700 text-slate-200 border border-white/10 text-sm mb-4 placeholder-slate-500" oninput="toggleDeleteButton()">
            <div class="flex gap-3">
                <button onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2 rounded-lg bg-slate-700 text-slate-200 hover:bg-slate-600 transition">Batal</button>
                <button id="deleteConfirmBtn" onclick="confirmDelete()" class="flex-1 px-4 py-2 rounded-lg bg-rose-600 text-white opacity-50 cursor-not-allowed transition" disabled>Hapus</button>
            </div>
        </div>
    </div>

</x-layouts.app>

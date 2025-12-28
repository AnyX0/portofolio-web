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
    <div class="mb-4 flex gap-2">
        <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 rounded-lg text-sm {{ !request('status') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5' }}">Semua</a>
        <a href="{{ route('admin.projects.index', ['status' => 'published']) }}" class="px-3 py-2 rounded-lg text-sm {{ request('status') === 'published' ? 'bg-emerald-500/20 text-emerald-300' : 'text-slate-400 hover:bg-white/5' }}">Published</a>
        <a href="{{ route('admin.projects.index', ['status' => 'draft']) }}" class="px-3 py-2 rounded-lg text-sm {{ request('status') === 'draft' ? 'bg-amber-500/20 text-amber-300' : 'text-slate-400 hover:bg-white/5' }}">Draft</a>
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
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="px-2 py-1 rounded text-cyan-300 hover:bg-cyan-500/10 text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 rounded text-rose-300 hover:bg-rose-500/10 text-xs font-medium" onclick="return confirm('Hapus project ini? Tindakan tidak dapat dibatalkan.')">Hapus</button>
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
</x-layouts.app>

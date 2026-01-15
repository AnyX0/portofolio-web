<x-layouts.app title="Arsip Project">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Console</p>
            <h1 class="text-2xl font-semibold text-white">Arsip Project</h1>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-lg border border-white/10 text-white font-semibold text-sm hover:bg-white/5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Project
        </a>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="mb-6">
        <div class="rounded-lg border border-slate-400/20 bg-slate-500/10 p-3 inline-block">
            <p class="text-xs text-slate-400 mb-1">Total Arsip</p>
            <p class="text-xl font-semibold text-slate-200">{{ $projects->total() }}</p>
        </div>
    </div>

    @if($projects->count() > 0)
        <!-- Projects Table -->
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-slate-200">
                    <thead class="bg-white/5 sticky top-0">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-slate-300">Project</th>
                            <th class="text-left px-4 py-3 font-medium text-slate-300">Deskripsi</th>
                            <th class="text-left px-4 py-3 font-medium text-slate-300">Status</th>
                            <th class="text-left px-4 py-3 font-medium text-slate-300">Diarsipkan</th>
                            <th class="text-left px-4 py-3 font-medium text-slate-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($projects as $project)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $images = $fetcher->getProjectImages($project->cloudinary_folder);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <div class="w-16 h-16 rounded-lg bg-white/5 overflow-hidden shrink-0">
                                                <img src="{{ $firstImage }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-slate-700 to-slate-800 shrink-0"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-white">{{ $project->title }}</p>
                                            <p class="text-xs text-slate-400">{{ $project->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-slate-300 line-clamp-2">{{ Str::limit($project->description, 80) }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    @if($project->published_at)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-400/20">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-amber-500/20 text-amber-300 border border-amber-400/20">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-slate-400 text-xs">{{ $project->archived_at->format('d M Y') }}</p>
                                    <p class="text-slate-500 text-xs">{{ $project->archived_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Unarchive Button -->
                                        <form method="POST" action="{{ route('admin.projects.unarchive', $project) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-lg hover:bg-emerald-500/10 text-emerald-400 hover:text-emerald-300 transition-all group" title="Pulihkan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                            </button>
                                        </form>
                                        
                                        <!-- Delete Button -->
                                        <button onclick="openDeleteModal({{ $project->id }}, '{{ $project->title }}')" class="p-2 rounded-lg hover:bg-rose-500/10 text-rose-400 hover:text-rose-300 transition-all group" title="Hapus Permanen">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="px-4 py-3 border-t border-white/10 bg-white/5">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-12 rounded-2xl border border-white/10 bg-white/5">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-slate-400 text-lg font-medium">Tidak ada project yang diarsipkan</p>
            <p class="text-slate-500 text-sm mt-1">Project yang diarsipkan akan muncul di sini</p>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-900 rounded-2xl border border-white/10 shadow-2xl max-w-md w-full p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="p-3 rounded-full bg-rose-500/10">
                    <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white mb-1">Hapus Project Permanen?</h3>
                    <p class="text-sm text-slate-400">Project "<span id="deleteProjectTitle" class="text-white font-medium"></span>" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Ketik <span class="text-rose-400 font-semibold">Hapus</span> untuk konfirmasi:</label>
                <input type="text" id="deleteConfirmInput" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent" placeholder="Hapus">
            </div>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 transition">Batal</button>
                <button id="confirmDeleteBtn" disabled onclick="confirmDelete()" class="px-4 py-2 rounded-lg text-sm font-medium bg-rose-500 text-white hover:bg-rose-600 transition disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-rose-500">Hapus Permanen</button>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        let deleteProjectId = null;

        function openDeleteModal(projectId, projectTitle) {
            deleteProjectId = projectId;
            document.getElementById('deleteProjectTitle').textContent = projectTitle;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteConfirmInput').value = '';
            document.getElementById('confirmDeleteBtn').disabled = true;
            document.getElementById('deleteConfirmInput').focus();
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteProjectId = null;
        }

        document.getElementById('deleteConfirmInput').addEventListener('input', function() {
            const input = this.value.trim().toLowerCase();
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.disabled = input !== 'hapus';
        });

        document.getElementById('deleteConfirmInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const input = this.value.trim().toLowerCase();
                if (input === 'hapus') {
                    confirmDelete();
                }
            }
        });

        function confirmDelete() {
            if (!deleteProjectId) return;
            
            const form = document.getElementById('deleteForm');
            form.action = `/console/projects/${deleteProjectId}`;
            form.submit();
        }

        // Close modal on backdrop click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</x-layouts.app>

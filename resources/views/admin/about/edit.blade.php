<x-layouts.app title="Edit About Page">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Console</p>
            <h1 class="text-2xl font-semibold text-white">Edit About Page</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-300 hover:text-white">Kembali</a>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.about.update') }}" class="space-y-5 max-w-3xl">
        @csrf
        @method('PUT')

        <!-- Contact Information -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Contact Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-slate-300">Email</label>
                    <input name="email" type="email" value="{{ old('email', $about->email) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('email')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-slate-300">Phone</label>
                    <input name="phone" type="text" value="{{ old('phone', $about->phone) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('phone')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-slate-300">Location</label>
                    <input name="location" type="text" value="{{ old('location', $about->location) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('location')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-slate-300">Availability Status</label>
                    <input name="availability" type="text" value="{{ old('availability', $about->availability) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('availability')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-slate-300">Bio (Optional)</label>
                    <textarea name="bio" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" rows="4">{{ old('bio', $about->bio) }}</textarea>
                    @error('bio')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Skills</h3>
            <p class="text-xs text-slate-400 mb-3">Pisahkan dengan koma (contoh: Flutter, Laravel, React)</p>
            <input name="skills" type="text" value="{{ old('skills', is_array($about->skills) ? implode(', ', $about->skills) : '') }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" placeholder="Flutter, Laravel, Tailwind">
            @error('skills')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Timeline -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Timeline / Experience</h3>
            <div id="timelineContainer" class="space-y-3">
                @if(old('timeline'))
                    @foreach(old('timeline') as $index => $item)
                        <div class="timeline-item rounded-lg border border-white/10 bg-slate-900/50 p-4">
                            <div class="grid md:grid-cols-3 gap-3">
                                <input name="timeline[{{ $index }}][year]" type="text" value="{{ $item['year'] ?? '' }}" placeholder="Tahun" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                                <input name="timeline[{{ $index }}][title]" type="text" value="{{ $item['title'] ?? '' }}" placeholder="Job Title" class="md:col-span-2 rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            </div>
                            <textarea name="timeline[{{ $index }}][desc]" placeholder="Deskripsi" class="mt-2 w-full rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm" rows="2">{{ $item['desc'] ?? '' }}</textarea>
                            <button type="button" onclick="this.parentElement.remove()" class="mt-2 text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                        </div>
                    @endforeach
                @elseif($about->timeline)
                    @foreach($about->timeline as $index => $item)
                        <div class="timeline-item rounded-lg border border-white/10 bg-slate-900/50 p-4">
                            <div class="grid md:grid-cols-3 gap-3">
                                <input name="timeline[{{ $index }}][year]" type="text" value="{{ $item['year'] ?? '' }}" placeholder="Tahun" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                                <input name="timeline[{{ $index }}][title]" type="text" value="{{ $item['title'] ?? '' }}" placeholder="Job Title" class="md:col-span-2 rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            </div>
                            <textarea name="timeline[{{ $index }}][desc]" placeholder="Deskripsi" class="mt-2 w-full rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm" rows="2">{{ $item['desc'] ?? '' }}</textarea>
                            <button type="button" onclick="this.parentElement.remove()" class="mt-2 text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" onclick="addTimelineItem()" class="mt-4 px-4 py-2 rounded-lg bg-cyan-500/20 text-cyan-300 text-sm hover:bg-cyan-500/30 transition">+ Tambah Timeline</button>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-4 py-3 rounded-xl bg-gradient-to-r from-cyan-400 to-indigo-500 text-slate-950 font-semibold shadow-lg shadow-indigo-500/20">Simpan Perubahan</button>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-300 hover:text-white">Batal</a>
        </div>
    </form>

    <script>
        let timelineIndex = {{ old('timeline') ? count(old('timeline')) : ($about->timeline ? count($about->timeline) : 0) }};

        function addTimelineItem() {
            const container = document.getElementById('timelineContainer');
            const item = document.createElement('div');
            item.className = 'timeline-item rounded-lg border border-white/10 bg-slate-900/50 p-4';
            item.innerHTML = `
                <div class="grid md:grid-cols-3 gap-3">
                    <input name="timeline[${timelineIndex}][year]" type="text" placeholder="Tahun" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                    <input name="timeline[${timelineIndex}][title]" type="text" placeholder="Job Title" class="md:col-span-2 rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                </div>
                <textarea name="timeline[${timelineIndex}][desc]" placeholder="Deskripsi" class="mt-2 w-full rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm" rows="2"></textarea>
                <button type="button" onclick="this.parentElement.remove()" class="mt-2 text-xs text-rose-400 hover:text-rose-300">Hapus</button>
            `;
            container.appendChild(item);
            timelineIndex++;
        }
    </script>
</x-layouts.app>

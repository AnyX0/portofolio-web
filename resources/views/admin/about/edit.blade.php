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

        <!-- Identitas Pribadi -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Identitas</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-slate-300">Nama</label>
                    <input name="name" type="text" value="{{ old('name', $about->name) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('name')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-slate-300">Gelar / Title</label>
                    <input name="title" type="text" value="{{ old('title', $about->title) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
                    @error('title')<p class="text-rose-200 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

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

        <!-- Skills (structured) -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-white">Skills / Fokus</h3>
                <button type="button" onclick="addSkillItem()" class="px-3 py-2 rounded-lg bg-cyan-500/20 text-cyan-200 text-xs border border-cyan-400/30 hover:bg-cyan-500/30">+ Tambah Skill</button>
            </div>
            <p class="text-xs text-slate-400 mb-4">Isi tiga bidang: Jenis (kategori), Judul (headline), Detail (deskripsi singkat).</p>

            <div id="skillsContainer" class="space-y-3">
                @php
                    $skillsOld = old('skills');
                    $skillsData = $skillsOld !== null ? $skillsOld : (is_array($about->skills) ? $about->skills : []);
                @endphp

                @forelse($skillsData as $index => $skill)
                    <div class="skill-item rounded-lg border border-white/10 bg-slate-900/50 p-4 space-y-2">
                        <div class="grid md:grid-cols-3 gap-3">
                            <input name="skills[{{ $index }}][type]" type="text" value="{{ $skill['type'] ?? '' }}" placeholder="Jenis (mis: Fokus, Stack)" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            <input name="skills[{{ $index }}][title]" type="text" value="{{ $skill['title'] ?? '' }}" placeholder="Judul" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            <input name="skills[{{ $index }}][detail]" type="text" value="{{ $skill['detail'] ?? '' }}" placeholder="Detail singkat" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                    </div>
                @empty
                    <div class="skill-item rounded-lg border border-white/10 bg-slate-900/50 p-4 space-y-2">
                        <div class="grid md:grid-cols-3 gap-3">
                            <input name="skills[0][type]" type="text" placeholder="Jenis (mis: Fokus, Stack)" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            <input name="skills[0][title]" type="text" placeholder="Judul" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                            <input name="skills[0][detail]" type="text" placeholder="Detail singkat" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                    </div>
                @endforelse
            </div>
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
        let skillsIndex = {{ $skillsData ? count($skillsData) : 1 }};

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

        function addSkillItem() {
            const container = document.getElementById('skillsContainer');
            const item = document.createElement('div');
            item.className = 'skill-item rounded-lg border border-white/10 bg-slate-900/50 p-4 space-y-2';
            item.innerHTML = `
                <div class="grid md:grid-cols-3 gap-3">
                    <input name="skills[${skillsIndex}][type]" type="text" placeholder="Jenis (mis: Fokus, Stack)" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                    <input name="skills[${skillsIndex}][title]" type="text" placeholder="Judul" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                    <input name="skills[${skillsIndex}][detail]" type="text" placeholder="Detail singkat" class="rounded-lg bg-slate-900/70 border border-white/10 px-3 py-2 text-sm">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-xs text-rose-400 hover:text-rose-300">Hapus</button>
            `;
            container.appendChild(item);
            skillsIndex++;
        }
    </script>
</x-layouts.app>

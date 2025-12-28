<x-layouts.app title="Edit Project">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Console</p>
            <h1 class="text-2xl font-semibold text-white">Edit Project</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-300 hover:text-white">Kembali</a>
    </div>

    @if(session('upload_warning'))
        <div class="rounded-xl border border-amber-400/40 bg-amber-400/10 text-amber-100 p-3 mb-4">
            {{ session('upload_warning') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="space-y-5 max-w-3xl" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.projects.partials.form')
    </form>
</x-layouts.app>

@props(['project', 'class' => 'w-full h-40 object-cover object-center'])

<div class="relative overflow-hidden rounded-none border-y border-white/10 bg-slate-900/50" {{ $attributes->merge(['class' => '']) }}>
    @if($project->cloudinary_folder)
        <!-- Fetch first image from Cloudinary folder -->
        <img 
            src="https://res.cloudinary.com/{{ config('services.cloudinary.cloud_name') }}/image/fetch/c_fill,w_800,h_600/cloudinary_folder:{{ $project->cloudinary_folder }}"
            alt="{{ $project->title }}" 
            class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-700 ease-in-out opacity-100 hover:opacity-90"
            loading="lazy"
            decoding="async"
            onerror="this.style.display='none'"
        >
    @endif
    
    <!-- Fade overlay for gallery effect -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    
    <!-- Placeholder/Loading state -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-700 to-slate-800 {{ $project->cloudinary_folder ? '' : 'animate-pulse' }}" data-placeholder></div>
</div>

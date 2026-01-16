@php($current = $project ?? null)

<!-- Upload Progress Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-slate-800 rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-white font-semibold mb-4" id="uploadTitle">Mengunggah gambar...</h3>
        <div class="w-full bg-slate-700 rounded-lg h-2 overflow-hidden mb-2">
            <div id="uploadProgress" class="bg-gradient-to-r from-cyan-400 to-indigo-500 h-full transition-all duration-300" style="width: 0%"></div>
        </div>
        <p class="text-sm text-slate-400"><span id="uploadPercent">0</span>% - <span id="uploadStatus">Mempersiapkan...</span></p>
    </div>
</div>

<div class="space-y-2">
    <label class="text-sm text-slate-300">Judul <span class="text-cyan-400">*</span></label>
    <input name="title" type="text" value="{{ old('title', optional($current)->title) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
    <p id="folderPreview" class="text-xs text-cyan-300 mt-1">📁 Folder Cloudinary akan otomatis dibuat berdasarkan judul ini</p>
    @error('title')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
</div>

<div class="space-y-2">
    <label class="text-sm text-slate-300">Ringkasan</label>
    <textarea name="summary" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" rows="3" required>{{ old('summary', optional($current)->summary) }}</textarea>
    @error('summary')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
</div>

<div class="space-y-2">
    <label class="text-sm text-slate-300">Deskripsi</label>
    <textarea name="description" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" rows="6">{{ old('description', optional($current)->description) }}</textarea>
    @error('description')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="space-y-2">
        <label class="text-sm text-slate-300">Tech stack (pisahkan koma)</label>
        <input name="tech_stack" type="text" value="{{ old('tech_stack', optional($current)->tech_stack) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none">
        @error('tech_stack')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="space-y-2">
        <label class="text-sm text-slate-300">Live URL</label>
        <input name="live_url" type="url" value="{{ old('live_url', optional($current)->live_url) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none">
        @error('live_url')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

<div class="space-y-2">
    <label class="text-sm text-slate-300">Upload Gambar Project (bisa multiple)</label>
    <input 
        name="cover_images[]" 
        id="coverImages" 
        type="file" 
        accept="image/*" 
        multiple
        class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-2 text-sm focus:border-cyan-400 focus:outline-none">
    <p class="text-xs text-slate-400">💡 Tip: Pilih gambar, lihat progress upload, kemudian simpan.</p>
    @error('cover_images')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
    @error('cover_images.*')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
</div>

@if(!empty($images))
<div class="space-y-2">
    <p class="text-xs text-slate-400">Gambar yang sudah di-upload:</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="existingImages">
        @foreach($images as $image)
            <div class="relative group" data-image-url="{{ $image }}">
                <img src="{{ $image }}" alt="Existing" class="w-full h-24 object-cover rounded-lg border border-white/10 group-hover:border-cyan-400 transition">
                <button 
                    type="button"
                    class="deleteImageBtn absolute top-1 right-1 w-6 h-6 rounded-full bg-rose-500 text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-600"
                    data-image-url="{{ $image }}">
                    ×
                </button>
                <div class="deleteProgress absolute inset-0 rounded-lg bg-rose-500/20 opacity-0 flex items-center justify-center">
                    <div class="text-white text-xs">Menghapus...</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="space-y-2">
    <p class="text-xs text-slate-400">Preview gambar baru:</p>
    <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
</div>

<div class="space-y-2">
    <label class="text-sm text-slate-300">Repo URL</label>
    <input name="repo_url" type="url" value="{{ old('repo_url', optional($current)->repo_url) }}" class="w-full rounded-xl bg-slate-900/70 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none">
    @error('repo_url')<p class="text-rose-200 text-xs">{{ $message }}</p>@enderror
</div>

<label class="inline-flex items-center gap-2 text-sm text-slate-300">
    <input type="hidden" name="is_published" value="0">
    <input type="checkbox" name="is_published" value="1" {{ old('is_published', optional($current)->is_published ?? true) ? 'checked' : '' }} class="rounded border-white/20 bg-slate-900/80">
    Publish segera
</label>

<div class="flex items-center gap-3 pt-2">
    <button type="submit" id="submitBtn" class="px-4 py-3 rounded-xl bg-gradient-to-r from-cyan-400 to-indigo-500 text-slate-950 font-semibold shadow-lg shadow-indigo-500/20">Simpan</button>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-300 hover:text-white">Batal</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('coverImages');
    const previewContainer = document.getElementById('imagePreview');
    const form = input.closest('form');
    const uploadModal = document.getElementById('uploadModal');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadPercent = document.getElementById('uploadPercent');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadTitle = document.getElementById('uploadTitle');
    
    let filesArray = [];
    
    // Real-time folder preview
    function updateFolderPreview() {
        const titleInput = document.querySelector('input[name="title"]');
        const folderPreview = document.getElementById('folderPreview');
        
        if (!titleInput || !folderPreview) return;
        
        const title = titleInput.value.trim();
        if (!title) {
            folderPreview.textContent = '📁 Folder Cloudinary akan otomatis dibuat berdasarkan judul ini';
            folderPreview.className = 'text-xs text-cyan-300 mt-1';
            return;
        }
        
        const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        const folderName = 'portfolio/projects/' + slug;
        folderPreview.textContent = '📁 Folder: ' + folderName;
        folderPreview.className = 'text-xs text-emerald-300 mt-1 font-semibold';
    }
    
    const titleInput = document.querySelector('input[name="title"]');
    if (titleInput) {
        titleInput.addEventListener('input', updateFolderPreview);
        updateFolderPreview(); // Initial preview
    }
    
    if (input) {
        input.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            filesArray = [...filesArray, ...newFiles];
            updatePreviews();
            updateInputFiles();
            input.value = '';
        });
    }
    
    // Handle form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // If no new files, submit normally
            if (filesArray.length === 0) {
                form.submit();
                return;
            }
            
            // Show upload modal
            uploadModal.classList.remove('hidden');
            uploadTitle.textContent = 'Mengunggah ' + filesArray.length + ' gambar...';
            
            try {
                // For create form (no project yet), we'll use the title's slug
                // For edit form, use existing cloudinary_folder
                let cloudinaryFolder = '{{ $project->cloudinary_folder ?? "" }}';
                
                if (!cloudinaryFolder) {
                    const titleInput = document.querySelector('input[name="title"]');
                    if (!titleInput || !titleInput.value.trim()) {
                        throw new Error('⚠️ Harap isi judul project terlebih dahulu sebelum upload gambar');
                    }
                    
                    // Extract slug from title for new projects (same as Laravel Str::slug)
                    const title = titleInput.value.trim();
                    const slug = title.toLowerCase()
                        .replace(/[^\w\s-]/g, '')  // Remove special chars
                        .replace(/\s+/g, '-')      // Replace spaces with dash
                        .replace(/-+/g, '-')       // Replace multiple dashes with single
                        .replace(/^-+|-+$/g, '');  // Remove leading/trailing dashes
                    
                    if (!slug) {
                        throw new Error('⚠️ Judul project tidak valid untuk membuat folder');
                    }
                    
                    cloudinaryFolder = 'portfolio/projects/' + slug;
                    console.log('📁 Folder Cloudinary dibuat: ' + cloudinaryFolder);
                }
                
                for (let i = 0; i < filesArray.length; i++) {
                    const file = filesArray[i];
                    const percent = Math.round(((i) / filesArray.length) * 100);
                    uploadProgress.style.width = percent + '%';
                    uploadPercent.textContent = percent;
                    uploadStatus.textContent = 'Mengunggah: ' + file.name;
                    
                    await uploadToCloudinary(file, cloudinaryFolder);
                    
                    const newPercent = Math.round(((i + 1) / filesArray.length) * 100);
                    uploadProgress.style.width = newPercent + '%';
                    uploadPercent.textContent = newPercent;
                }
                
                uploadStatus.textContent = 'Selesai!';
                
                setTimeout(() => {
                    uploadModal.classList.add('hidden');
                    form.submit();
                }, 500);
                
            } catch (error) {
                uploadTitle.textContent = 'Upload Gagal!';
                uploadStatus.textContent = 'Error: ' + error.message;
                console.error('Upload error:', error);
                setTimeout(() => {
                    uploadModal.classList.add('hidden');
                    alert('Error uploading images: ' + error.message);
                }, 2000);
            }
        });
    }
    
    async function uploadToCloudinary(file, folder) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('folder', folder);
        
        const response = await fetch('{{ route("admin.uploadImage") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            body: formData,
        });
        
        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Upload failed');
        }
        
        return data.url;
    }
    
    function updatePreviews() {
        previewContainer.innerHTML = '';
        
        filesArray.forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group cursor-move';
                wrapper.draggable = true;
                wrapper.dataset.index = index;
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-24 object-cover rounded-lg border border-white/10 transition-all group-hover:border-cyan-400';
                
                const badge = document.createElement('div');
                badge.className = 'absolute top-1 left-1 w-6 h-6 rounded-full bg-cyan-500 text-white text-xs font-bold flex items-center justify-center';
                badge.textContent = index + 1;
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.innerHTML = '×';
                removeBtn.className = 'absolute top-1 right-1 w-6 h-6 rounded-full bg-rose-500 text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-600';
                removeBtn.onclick = function(e) {
                    e.stopPropagation();
                    filesArray.splice(index, 1);
                    updatePreviews();
                    updateInputFiles();
                };
                
                const fileName = document.createElement('p');
                fileName.textContent = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
                fileName.className = 'text-xs text-slate-400 mt-1 truncate';
                
                wrapper.appendChild(img);
                wrapper.appendChild(badge);
                wrapper.appendChild(removeBtn);
                wrapper.appendChild(fileName);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
    
    function updateInputFiles() {
        const dt = new DataTransfer();
        filesArray.forEach(file => dt.items.add(file));
        input.files = dt.files;
    }
    
    // Delete existing images functionality
    document.querySelectorAll('.deleteImageBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const imageUrl = this.dataset.imageUrl;
            const container = this.closest('div[data-image-url]');
            const progress = container.querySelector('.deleteProgress');
            
            if (!imageUrl) {
                alert('Error: Image URL not found');
                return;
            }
            
            if (!confirm('Yakin ingin menghapus gambar ini?')) {
                return;
            }
            
            progress.style.opacity = '100';
            
            fetch('{{ isset($project) ? route("admin.projects.deleteImage", $project) : "#" }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    image_url: imageUrl,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    container.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => container.remove(), 300);
                } else {
                    alert('Error: ' + (data.error || 'Gagal menghapus gambar'));
                    progress.style.opacity = '0';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
                progress.style.opacity = '0';
            });
        });
    });
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.8); }
        }
    `;
    document.head.appendChild(style);
});
</script>

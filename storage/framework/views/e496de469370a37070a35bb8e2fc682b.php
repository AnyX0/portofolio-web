<?php ($title = 'Tentang Saya — Andi'); ?>
<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?>
    <section class="grid lg:grid-cols-[1.2fr,1fr] gap-10 items-start">
        <div class="relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl shadow-cyan-500/10 space-y-6">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-indigo-500/10 to-transparent pointer-events-none"></div>
            <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em]">Tentang Saya</p>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <span class="text-xl font-semibold tracking-tight">AU</span>
                </div>
                <div>
                    <h1 class="text-4xl font-semibold text-white leading-tight">Andi Utama</h1>
                    <p class="text-slate-300">Mobile & Web Engineer</p>
                </div>
            </div>
            <div class="space-y-4 text-slate-200 leading-relaxed">
                <p class="text-lg">Saya membangun produk dengan pendekatan arsitektur bersih, motion halus, dan pipeline otomatis. Fokus pada performa, kestabilan, serta dokumentasi yang bisa diandalkan tim.</p>
                <div class="grid sm:grid-cols-3 gap-3 text-sm">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Fokus</p>
                        <p class="text-white font-semibold">Performa & UX</p>
                        <p class="text-[12px] text-slate-400">Micro-interactions, smooth flow.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Stack</p>
                        <p class="text-white font-semibold">Flutter · Laravel</p>
                        <p class="text-[12px] text-slate-400">Tailwind, TS, REST/WS.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-1">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Pipeline</p>
                        <p class="text-white font-semibold">CI/CD & QA</p>
                        <p class="text-[12px] text-slate-400">Testing, linting, rollout.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-slate-200 text-sm shadow-sm shadow-cyan-500/10"><?php echo e($skill); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-xl shadow-indigo-500/10 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Kontak</p>
                    <h2 class="text-xl font-semibold text-white">Mari Berkolaborasi</h2>
                </div>
                <span class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-400/20 to-indigo-500/20 text-[11px] text-slate-100 border border-white/10">Fast response</span>
            </div>

            <div class="grid sm:grid-cols-2 gap-3 text-sm text-slate-200">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-2">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Email</p>
                    <p class="text-white font-semibold break-words"><?php echo e($contact['email']); ?></p>
                    <div class="flex gap-2 text-[12px]">
                        <button type="button" class="copy-btn px-3 py-1.5 rounded-lg bg-white/10 border border-white/10 text-slate-100 hover:border-cyan-300" data-copy="<?php echo e($contact['email']); ?>">Copy</button>
                        <a href="mailto:<?php echo e($contact['email']); ?>" class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-cyan-400/20 to-indigo-500/20 border border-white/10 text-slate-100 hover:border-cyan-300">Email</a>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-2">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Telepon</p>
                    <p class="text-white font-semibold break-words"><?php echo e($contact['phone']); ?></p>
                    <div class="flex gap-2 text-[12px]">
                        <button type="button" class="copy-btn px-3 py-1.5 rounded-lg bg-white/10 border border-white/10 text-slate-100 hover:border-cyan-300" data-copy="<?php echo e($contact['phone']); ?>">Copy</button>
                        <a href="https://wa.me/<?php echo e(preg_replace('/\D/', '', $contact['phone'])); ?>" class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-emerald-400/20 to-cyan-500/20 border border-white/10 text-slate-100 hover:border-emerald-300" target="_blank">WhatsApp</a>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Lokasi</p>
                    <p class="text-white font-semibold"><?php echo e($contact['location']); ?></p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Ketersediaan</p>
                    <p class="text-emerald-200 font-semibold"><?php echo e($contact['availability']); ?></p>
                </div>
            </div>

            <div class="h-px w-full bg-gradient-to-r from-white/30 via-white/10 to-transparent"></div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm uppercase tracking-[0.25em] text-slate-400">Riwayat Singkat</h3>
                    <span class="text-[12px] text-slate-400">Ringkasan perjalanan</span>
                </div>
                <ul class="space-y-3">
                    <?php $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-cyan-200"><?php echo e($item['year']); ?></span>
                                <span class="px-2 py-1 rounded-full bg-white/10 text-[11px] text-slate-200 border border-white/10"><?php echo e($item['title']); ?></span>
                            </div>
                            <p class="text-sm text-slate-200 leading-relaxed"><?php echo e($item['desc']); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH E:\Andi\Documents\Kuliah\PEMROGRAMAN MOBILE - SMT5\StudioProjects\project_uas\resources\views/about.blade.php ENDPATH**/ ?>
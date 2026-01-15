<?php
    $title = 'Andi — Mobile & Web Engineer';
?>
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
    <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center justify-center">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 w-[50vw] h-[50vw] rounded-full bg-gradient-to-br from-fuchsia-500/20 via-rose-400/10 to-amber-400/20 blur-3xl animate-pulse"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -right-24 w-[45vw] h-[45vw] rounded-full bg-gradient-to-tr from-sky-500/20 via-indigo-400/10 to-violet-500/20 blur-3xl animate-pulse"></div>
        
        <div class="relative text-center space-y-8 max-w-4xl">
            <div class="space-y-4">
                <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em] animate-fade-in">Welcome to My Portfolio</p>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-pink-400 to-sky-400 animate-fade-in-up">
                    Crafting Digital<br>Experiences
                </h1>
                <p class="text-xl lg:text-2xl text-slate-300 max-w-2xl mx-auto animate-fade-in-up animation-delay-200">
                    Mobile & Web Developer yang berfokus pada arsitektur bersih, performa tinggi, dan pengalaman pengguna yang luar biasa.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 animate-fade-in-up animation-delay-400">
                <a href="<?php echo e(route('projects')); ?>" class="group px-8 py-4 rounded-full bg-gradient-to-r from-cyan-500 to-indigo-500 text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transition-all hover:scale-105">
                    <span class="flex items-center gap-2">
                        Lihat Projects
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </a>
                <a href="<?php echo e(route('about')); ?>" class="px-8 py-4 rounded-full bg-white/5 backdrop-blur-xl border border-white/10 text-slate-200 font-semibold hover:bg-white/10 transition-all hover:scale-105">
                    Tentang Saya
                </a>
            </div>

            <div class="flex flex-wrap justify-center gap-3 pt-8 animate-fade-in-up animation-delay-600">
                <span class="px-4 py-2 rounded-full bg-emerald-400/10 text-emerald-200 text-sm border border-emerald-400/30">Flutter</span>
                <span class="px-4 py-2 rounded-full bg-indigo-400/10 text-indigo-200 text-sm border border-indigo-400/30">Laravel</span>
                <span class="px-4 py-2 rounded-full bg-cyan-400/10 text-cyan-100 text-sm border border-cyan-400/30">Tailwind CSS</span>
                <span class="px-4 py-2 rounded-full bg-amber-400/10 text-amber-100 text-sm border border-amber-400/30">Clean Architecture</span>
                <span class="px-4 py-2 rounded-full bg-rose-400/10 text-rose-200 text-sm border border-rose-400/30">RESTful API</span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 space-y-12">
        <div class="text-center space-y-4">
            <p class="text-sm text-cyan-300 font-medium uppercase tracking-[0.3em]">Why Choose Me</p>
            <h2 class="text-3xl lg:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-pink-400 to-indigo-400">
                Keunggulan & Fokus
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="group relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:shadow-cyan-500/10 transition-all hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center">
                        <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Performa Tinggi</h3>
                    <p class="text-slate-300 leading-relaxed">
                        Optimasi penuh dari database queries, caching strategi, hingga lazy loading. App cepat & responsif.
                    </p>
                </div>
            </div>

            <div class="group relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:shadow-indigo-500/10 transition-all hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-400/10 border border-indigo-400/30 flex items-center justify-center">
                        <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Clean Code</h3>
                    <p class="text-slate-300 leading-relaxed">
                        Arsitektur terstruktur, SOLID principles, dan best practices. Mudah di-maintain & scale.
                    </p>
                </div>
            </div>

            <div class="group relative overflow-hidden backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/10 transition-all hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-400/10 border border-emerald-400/30 flex items-center justify-center">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">UX First</h3>
                    <p class="text-slate-300 leading-relaxed">
                        Interface intuitif, animasi smooth, dan feedback responsif. Pengalaman pengguna yang menyenangkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="relative overflow-hidden backdrop-blur-xl bg-gradient-to-r from-cyan-500/10 via-indigo-500/10 to-pink-500/10 border border-white/10 rounded-3xl p-12 text-center shadow-2xl">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(56,189,248,0.15),transparent_70%)]"></div>
            <div class="relative space-y-6">
                <h2 class="text-3xl lg:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-pink-400">
                    Tertarik Bekerja Sama?
                </h2>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    Mari diskusikan project Anda. Saya siap membantu mewujudkan ide menjadi aplikasi yang solid dan production-ready.
                </p>
                <div class="flex flex-wrap justify-center gap-4 pt-4">
                    <a href="<?php echo e(route('projects')); ?>" class="px-8 py-4 rounded-full bg-gradient-to-r from-cyan-500 to-indigo-500 text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transition-all hover:scale-105">
                        Lihat Portfolio
                    </a>
                    <a href="mailto:andi@example.com" class="px-8 py-4 rounded-full bg-white/5 backdrop-blur-xl border border-white/10 text-slate-200 font-semibold hover:bg-white/10 transition-all hover:scale-105">
                        Hubungi Saya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
            animation-fill-mode: forwards;
        }
    </style>
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
<?php /**PATH E:\Andi\Documents\Kuliah\PEMROGRAMAN MOBILE - SMT5\StudioProjects\portofolio-web\resources\views/welcome.blade.php ENDPATH**/ ?>
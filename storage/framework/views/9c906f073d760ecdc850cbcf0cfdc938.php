<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Console Access</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-cyan-500/10">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400 mb-2">Stealth login</p>
        <h1 class="text-2xl font-semibold text-white mb-6">Masuk ke admin console</h1>
        <?php if($errors->any()): ?>
            <div class="mb-4 rounded-2xl border border-rose-400/40 bg-rose-500/10 text-rose-100 px-4 py-3 text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('admin.login.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Email</label>
                <input name="email" type="email" value="<?php echo e(old('email')); ?>" class="w-full rounded-xl bg-slate-900/80 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required autofocus>
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300">Password</label>
                <input name="password" type="password" class="w-full rounded-xl bg-slate-900/80 border border-white/10 px-4 py-3 text-sm focus:border-cyan-400 focus:outline-none" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-300">
                <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-slate-900/80">
                Remember session
            </label>
            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-gradient-to-r from-cyan-400 to-indigo-500 text-slate-950 font-semibold hover:shadow-lg hover:shadow-indigo-500/20 transition">
                Masuk
            </button>
        </form>
        <p class="text-[11px] text-slate-500 mt-4 text-center">Route disembunyikan, jangan dibagikan.</p>
    </div>
</body>
</html>
<?php /**PATH E:\Andi\Documents\Kuliah\PEMROGRAMAN MOBILE - SMT5\StudioProjects\project_uas\resources\views/admin/login.blade.php ENDPATH**/ ?>
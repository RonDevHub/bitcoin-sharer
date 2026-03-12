<!DOCTYPE html>
<html lang="<?= $i18n->getLang() ?>" x-data="setup()" :class="{ 'dark': darkMode }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $i18n->t('title') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = { darkMode: 'class' };
        function setup() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark' || 
                         (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toasts: [],
                toggleDark() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                },
                addToast(message, type = 'success') {
                    const id = Date.now();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 3000);
                },
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.addToast('<?= $i18n->getLang() === "de" ? "Kopiert!" : "Copied!" ?>');
                    });
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .qr-wrapper svg { width: 100%; height: auto; max-width: 180px; display: block; margin: 0 auto; }
        .dark .qr-wrapper svg { filter: invert(0.9) hue-rotate(180deg); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 min-h-screen flex items-center justify-center p-4 transition-colors duration-500">
    
    <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 flex flex-col gap-2 w-full max-w-xs">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white dark:bg-slate-800 shadow-2xl border-l-4 border-orange-500 p-4 rounded-lg flex items-center justify-between">
                <span class="text-sm font-medium" x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <div class="absolute top-4 right-4">
        <button @click="toggleDark()" class="p-3 bg-white dark:bg-slate-800 rounded-full shadow-lg hover:rotate-12 transition-all">
            <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
        </button>
    </div>

    <div class="max-w-md w-full bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-center border border-slate-100 dark:border-slate-800 relative overflow-hidden">
        <h1 class="text-3xl font-black mb-8 text-orange-500 tracking-tighter italic">₿ <?= $i18n->t('title') ?></h1>

        <?php if ($viewData): ?>
            <div class="group relative mb-6 p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl break-all font-mono text-xs border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-orange-500 transition-colors"
                 @click="copyToClipboard('<?= addslashes($viewData) ?>')">
                <?= htmlspecialchars($viewData) ?>
                <div class="absolute inset-0 flex items-center justify-center bg-orange-500/10 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl">
                    <span class="text-[10px] font-bold text-orange-600 uppercase">Klicken zum Kopieren</span>
                </div>
            </div>
            
            <div class="mb-8 p-4 bg-white rounded-3xl qr-wrapper shadow-inner ring-8 ring-slate-50 dark:ring-slate-800/30">
                <?= $qrOutput ?>
            </div>

            <button @click="copyToClipboard('<?= addslashes($viewData) ?>')" 
                    class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-black shadow-lg shadow-orange-500/20 transition-all active:scale-[0.98]">
                <?= $i18n->t('copy_btn') ?>
            </button>
            <a href="/" class="block mt-6 text-xs text-slate-400 hover:text-orange-500 uppercase tracking-widest font-bold"><?= $i18n->t('new_link') ?></a>

        <?php elseif ($error): ?>
            <div class="p-6 bg-red-50 dark:bg-red-950/30 text-red-500 rounded-3xl border border-red-100 dark:border-red-900/50 font-bold">
                <?= $i18n->t('error_invalid') ?>
            </div>
            <a href="/" class="block mt-6 underline text-sm">Zurück</a>

        <?php else: ?>
            <form method="POST" class="space-y-4">
                <div class="relative">
                    <input type="text" name="address" placeholder="<?= $i18n->t('input_placeholder') ?>" required 
                           class="w-full p-5 rounded-2xl border border-slate-200 dark:bg-slate-800 dark:border-slate-700 focus:ring-4 focus:ring-orange-500/20 outline-none transition-all text-center font-medium <?= isset($validationError) ? 'border-red-500 ring-4 ring-red-500/10' : '' ?>">
                    <?php if (isset($validationError)): ?>
                        <p class="text-[10px] text-red-500 mt-2 font-bold uppercase">Das ist keine valide Bitcoin Adresse!</p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="w-full py-5 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-black shadow-xl shadow-orange-500/20 transition-all active:scale-[0.98]">
                    <?= $i18n->t('generate_btn') ?>
                </button>
            </form>
            
            <?php if (isset($generatedLink)): ?>
                <div class="mt-8 p-5 bg-green-500/5 dark:bg-green-500/10 rounded-[2rem] border border-green-500/20 cursor-pointer group"
                     @click="copyToClipboard('<?= $generatedLink ?>')">
                    <p class="text-[10px] uppercase font-black mb-2 text-green-600 tracking-tighter"><?= $i18n->t('your_link') ?></p>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly value="<?= $generatedLink ?>" class="w-full bg-transparent outline-none text-center font-mono text-[12px] text-slate-500 cursor-pointer">
                        <span class="text-green-600 group-hover:scale-125 transition-transform">📋</span>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
      
        <div class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
            <p class="text-[9px] text-gray-400 uppercase tracking-[0.2em] font-medium"><?= $i18n->t('footer') ?></p>
        </div>
    </div>
</body>
</html>
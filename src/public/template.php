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
                // Initialisierung: LocalStorage geht vor, sonst System-Check
                darkMode: localStorage.getItem('theme') === 'dark' || 
                         (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                
                toggleDark() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                },
                
                init() {
                    // Lauscht auf System-Änderungen, falls kein manuelles Theme gesetzt wurde
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('theme')) {
                            this.darkMode = e.matches;
                        }
                    });
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Der Fix für das SVG */
        .qr-wrapper svg {
            width: 100%;
            height: auto;
            max-width: 200px;
            display: block;
            margin: 0 auto;
        }
        /* QR Code im Darkmode invertieren für bessere Lesbarkeit (optional) */
        .dark .qr-wrapper svg {
            filter: invert(0.9) hue-rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
    
    <div class="absolute top-4 right-4">
        <button @click="toggleDark()" class="p-3 bg-white dark:bg-gray-800 rounded-full shadow-lg hover:scale-110 transition-transform">
            <span x-show="!darkMode" title="Dark Mode">🌙</span>
            <span x-show="darkMode" title="Light Mode">☀️</span>
        </button>
    </div>

    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-2xl text-center border border-gray-100 dark:border-gray-700">
        <h1 class="text-3xl font-black mb-6 text-orange-500 tracking-tight">₿ <?= $i18n->t('title') ?></h1>

        <?php if ($viewData): ?>
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl break-all font-mono text-xs border border-gray-200 dark:border-gray-600 text-orange-600 dark:text-orange-400">
                <?= htmlspecialchars($viewData) ?>
            </div>
            
            <div class="mb-6 p-4 bg-white rounded-2xl qr-wrapper shadow-inner">
                <?= $qrOutput // Das rohe SVG ohne XML-Deklaration ?>
            </div>

            <button onclick="navigator.clipboard.writeText('<?= addslashes($viewData) ?>')" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold shadow-lg transition-all active:scale-95">
                <?= $i18n->t('copy_btn') ?>
            </button>
            <a href="/" class="block mt-6 text-sm text-gray-400 hover:text-orange-500 transition-colors"><?= $i18n->t('new_link') ?></a>
        <?php elseif ($error): ?>
            <div class="p-4 bg-red-100 dark:bg-red-900/20 text-red-500 rounded-xl font-bold mb-4">
                ⚠️ <?= $i18n->t('error_invalid') ?>
            </div>
            <a href="/" class="block underline">← Zurück</a>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <input type="text" name="address" placeholder="<?= $i18n->t('input_placeholder') ?>" required 
                       class="w-full p-4 rounded-xl border border-gray-200 dark:bg-gray-700 dark:border-gray-600 focus:ring-4 focus:ring-orange-500/20 outline-none transition-all text-center">
                <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold shadow-lg transition-all active:scale-95">
                    <?= $i18n->t('generate_btn') ?>
                </button>
            </form>
            
            <?php if ($generatedLink): ?>
                <div class="mt-8 p-4 bg-green-50 dark:bg-green-900/10 rounded-2xl border border-green-100 dark:border-green-900/30">
                    <p class="text-[10px] uppercase font-bold mb-2 text-green-600"><?= $i18n->t('your_link') ?></p>
                    <input type="text" readonly value="<?= $generatedLink ?>" class="w-full p-2 text-xs bg-transparent border-b border-green-500 focus:outline-none text-center font-mono text-gray-600 dark:text-gray-300">
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
            <p class="text-[9px] text-gray-400 uppercase tracking-[0.2em] font-medium"><?= $i18n->t('footer') ?></p>
        </div>
    </div>
</body>
</html>
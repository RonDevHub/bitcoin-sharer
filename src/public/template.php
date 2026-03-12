<!DOCTYPE html>
<html lang="<?= $i18n->getLang() ?>" x-data="setup()" :class="{ 'dark': darkMode }">
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
                         (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toggleDark() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Fix für den QR-Code, damit er nicht das Design sprengt */
        .qr-container svg { width: 100%; height: auto; max-width: 200px; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center p-4 transition-colors">
    
    <div class="absolute top-4 right-4">
        <button @click="toggleDark()" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-md hover:scale-110 transition">
            <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
        </button>
    </div>

    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center border border-gray-100 dark:border-gray-700">
        <h1 class="text-3xl font-bold mb-6 text-orange-500">₿ <?= $i18n->t('title') ?></h1>

        <?php if ($viewData): ?>
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg break-all font-mono text-sm border border-gray-200 dark:border-gray-600">
                <?= htmlspecialchars($viewData) ?>
            </div>
            
            <div class="flex justify-center mb-6 p-2 bg-white rounded-lg qr-container mx-auto">
                <?php if ($qrOutput): ?>
                    <?= $qrOutput // Hier wird das SVG direkt eingebettet ?>
                <?php endif; ?>
            </div>

            <button onclick="navigator.clipboard.writeText('<?= addslashes($viewData) ?>')" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold transition">
                <?= $i18n->t('copy_btn') ?>
            </button>
            <a href="/" class="block mt-4 text-sm text-gray-500 dark:text-gray-400 underline"><?= $i18n->t('new_link') ?></a>
        <?php elseif ($error): ?>
            <div class="text-red-500 font-bold mb-4"><?= $i18n->t('error_invalid') ?></div>
            <a href="/" class="block underline">← Zurück</a>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <input type="text" name="address" placeholder="<?= $i18n->t('input_placeholder') ?>" required 
                       class="w-full p-4 rounded-lg border dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold shadow-lg transition">
                    <?= $i18n->t('generate_btn') ?>
                </button>
            </form>
            
            <?php if ($generatedLink): ?>
                <div class="mt-8 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                    <p class="text-xs mb-2 text-green-700 dark:text-green-400"><?= $i18n->t('your_link') ?></p>
                    <input type="text" readonly value="<?= $generatedLink ?>" class="w-full p-2 text-xs bg-transparent border-b border-green-500 focus:outline-none text-center font-mono">
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <p class="mt-8 text-[10px] text-gray-400 uppercase tracking-widest"><?= $i18n->t('footer') ?></p>
    </div>
</body>
</html>
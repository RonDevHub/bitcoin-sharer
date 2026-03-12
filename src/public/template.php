<!DOCTYPE html>
<html lang="<?= $i18n->getLang() ?>" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $i18n->t('title') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center p-4 transition-colors">
    
    <div class="absolute top-4 right-4">
        <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-md">
            <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
        </button>
    </div>

    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center">
        <h1 class="text-3xl font-bold mb-6 text-orange-500">₿ <?= $i18n->t('title') ?></h1>

        <?php if ($viewData): ?>
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg break-all font-mono text-sm border border-gray-200 dark:border-gray-600">
                <?= htmlspecialchars($viewData) ?>
            </div>
            <div class="flex justify-center mb-6 bg-white p-2 rounded-lg inline-block mx-auto">
                <?= $qrOutput ?>
            </div>
            <button onclick="navigator.clipboard.writeText('<?= htmlspecialchars($viewData) ?>')" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold transition">
                <?= $i18n->t('copy_btn') ?>
            </button>
            <a href="/" class="block mt-4 text-sm text-gray-500 underline"><?= $i18n->t('new_link') ?></a>
        <?php elseif ($error): ?>
            <div class="text-red-500 font-bold"><?= $i18n->t('error_invalid') ?></div>
            <a href="/" class="block mt-4 underline">← Zurück</a>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <input type="text" name="address" placeholder="<?= $i18n->t('input_placeholder') ?>" required class="w-full p-4 rounded-lg border dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-orange-500 outline-none">
                <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold shadow-lg transition">
                    <?= $i18n->t('generate_btn') ?>
                </button>
            </form>
            <?php if ($generatedLink): ?>
                <div class="mt-8 p-4 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <p class="text-xs mb-2"><?= $i18n->t('your_link') ?></p>
                    <input type="text" readonly value="<?= $generatedLink ?>" class="w-full p-2 text-xs bg-transparent border-b border-green-500 focus:outline-none text-center">
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <p class="mt-8 text-[10px] text-gray-400 uppercase tracking-widest"><?= $i18n->t('footer') ?></p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="<?= $i18n->getLang() ?>" x-data="setup()" :class="{ 'dark': darkMode }" x-cloak>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($viewData): ?>
        <meta name="robots" content="noindex, nofollow">
        <title>Bitcoin Address Shared | <?= $i18n->t('title') ?></title>
        <link rel="icon" type="image/png" href="/logo.png">
        <link rel="apple-touch-icon" href="/logo.png">
    <?php else: ?>
        <title><?= $i18n->t('title') ?> - Share Bitcoin Addresses Anonymously</title>
        <meta name="description" content="Share your Bitcoin address easily and securely without any database or logging. Pure client-side encryption for maximum privacy.">
        <meta name="keywords" content="Bitcoin, BTC, Share Address, Anonymous, No Database, Privacy, QR Code Generator">
        <meta name="robots" content="index, follow">
        <meta name="author" content="RonDevHub">
        <link rel="icon" type="image/png" href="/logo.png">
        <link rel="apple-touch-icon" href="/logo.png">

        <meta property="og:title" content="<?= $i18n->t('title') ?> - Stateless BTC Sharing">
        <meta property="og:description" content="The most private way to share your Bitcoin address. No logs, no database.">
        <meta property="og:type" content="website">
    <?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };

        function setup() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toasts: [],
                showErr: <?= $validationError ? 'true' : 'false' ?>,
                toggleDark() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                },
                addToast(message) {
                    const id = Date.now();
                    this.toasts.push({
                        id,
                        message
                    });
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 3000);
                },
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.addToast('<?= $i18n->getLang() === "de" ? "Kopiert!" : "Copied!" ?>');
                    });
                },
                init() {
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('theme')) this.darkMode = e.matches;
                    });
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .qr-wrapper svg {
            width: 100%;
            height: auto;
            max-width: 180px;
            display: block;
            margin: 0 auto;
        }

        .dark .qr-wrapper svg {
            filter: invert(0.9) hue-rotate(180deg);
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 min-h-screen flex items-center justify-center p-4 transition-colors duration-500">

    <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex flex-col gap-2 w-full max-w-[200px]">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 scale-95"
                class="bg-white dark:bg-slate-800 shadow-xl border-l-4 border-orange-500 p-3 rounded-lg text-center text-sm font-bold">
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <div class="absolute top-4 right-4">
        <button @click="toggleDark()" class="p-3 bg-white dark:bg-slate-800 rounded-full shadow-lg hover:rotate-12 transition-all">
            <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
        </button>
    </div>

    <div class="max-w-md w-full bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-center border border-slate-100 dark:border-slate-800 relative">
        <h1 class="text-3xl font-black mb-8 text-orange-500 tracking-tighter italic">₿ <?= $i18n->t('title') ?></h1>

        <?php if ($viewData): ?>
            <div class="group relative mb-6 p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl break-all font-mono text-xs border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-orange-500 transition-colors"
                @click="copyToClipboard('<?= addslashes($viewData) ?>')">
                <?= htmlspecialchars($viewData) ?>
                <div class="absolute inset-0 flex items-center justify-center bg-orange-500/10 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl">
                    <span class="text-[10px] font-bold text-orange-600 uppercase"><?= $i18n->t('click') ?></span>
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
            <a href="/" class="block mt-6 underline text-orange-500 dark:text-orange-600 text-sm"><?= $i18n->t('back') ?></a>

        <?php else: ?>
            <form method="POST" class="space-y-4">
                <div>
                    <input type="text" name="address" @input="showErr = false"
                        placeholder="<?= $i18n->t('input_placeholder') ?>" required
                        class="w-full p-5 rounded-2xl border border-slate-200 dark:bg-slate-800 dark:border-slate-700 focus:ring-4 focus:ring-orange-500/20 outline-none transition-all text-center font-medium <?= $validationError ? 'border-red-500 ring-2 ring-red-500/20' : '' ?>">
                    <template x-if="showErr">
                        <p x-transition class="text-[10px] text-red-500 mt-2 font-bold uppercase tracking-widest italic">
                            <?= $i18n->t('validation_error') ?>
                        </p>
                    </template>
                </div>
                <button type="submit" class="w-full py-5 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-black shadow-xl shadow-orange-500/20 transition-all active:scale-[0.98]">
                    <?= $i18n->t('generate_btn') ?>
                </button>
            </form>

            <?php if ($generatedLink): ?>
                <div class="mt-8 p-2 bg-green-500/5 dark:bg-green-500/10 rounded-[2.5rem] border border-green-500/20 overflow-hidden">

                    <div class="p-4 hover:bg-green-500/10 transition-colors cursor-pointer group rounded-[2rem]"
                        @click="copyToClipboard('<?= $generatedLink ?>')">
                        <p class="text-[9px] uppercase font-black mb-1 text-green-600/60 tracking-tighter ml-2 text-left"><?= $i18n->t('your_link') ?></p>
                        <div class="flex items-center justify-between px-2">
                            <input type="text" readonly value="<?= $generatedLink ?>" class="w-full bg-transparent outline-none text-left font-mono text-[11px] text-slate-500 cursor-pointer">
                            <span class="text-green-600 group-hover:scale-110 transition-transform ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512">
                                    <path fill="currentColor" d="M384 336H192c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16h140.1L432 147.9V320c0 8.8-7.2 16-16 16zM192 384H384c35.3 0 64-28.7 64-64V147.9c0-12.7-5.1-24.9-14.1-33.9L330.1 10.1c-9-9-21.2-14.1-33.9-14.1H192c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H256c35.3 0 64-28.7 64-64V416H272v32c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192c0-8.8 7.2-16 16-16H96V128H64z" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="h-[1px] bg-green-500/10 mx-6"></div>

                    <?php $htmlLink = '<a href="' . $generatedLink . '" target="_blank">' . $i18n->t('visit_site') . '</a>'; ?>
                    <div class="p-4 hover:bg-green-500/10 transition-colors cursor-pointer group rounded-[2rem]"
                        @click="copyToClipboard('<?= addslashes($htmlLink) ?>')">
                        <p class="text-[9px] uppercase font-black mb-1 text-green-600/60 tracking-tighter ml-2 text-left"><?= $i18n->t('html_link') ?></p>
                        <div class="flex items-center justify-between px-2">
                            <input type="text" readonly value="<?= htmlspecialchars($htmlLink) ?>" class="w-full bg-transparent outline-none text-left font-mono text-[11px] text-slate-500 cursor-pointer">
                            <span class="text-green-600 group-hover:scale-110 transition-transform ml-2 italic text-[10px] font-bold">HTML</span>
                        </div>
                    </div>

                    <div class="h-[1px] bg-green-500/10 mx-6"></div>

                    <?php $mdLink = '[' . $i18n->t('visit_site') . '](' . $generatedLink . ')'; ?>
                    <div class="p-4 hover:bg-green-500/10 transition-colors cursor-pointer group rounded-[2rem]"
                        @click="copyToClipboard('<?= addslashes($mdLink) ?>')">
                        <p class="text-[9px] uppercase font-black mb-1 text-green-600/60 tracking-tighter ml-2 text-left"><?= $i18n->t('md_link') ?></p>
                        <div class="flex items-center justify-between px-2">
                            <input type="text" readonly value="<?= htmlspecialchars($mdLink) ?>" class="w-full bg-transparent outline-none text-left font-mono text-[11px] text-slate-500 cursor-pointer">
                            <span class="text-green-600 group-hover:scale-110 transition-transform ml-2 italic text-[10px] font-bold">MD</span>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium"><?= $i18n->t('footer') ?></p>
            <p class="text-sm pt-3 text-gray-400 font-medium"><?= $i18n->t('copy') ?></p>
        </div>
    </div>
</body>

</html>
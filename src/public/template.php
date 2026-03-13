<?php 
$htmlLink = '<a href="' . $generatedLink . '" target="_blank">' . $i18n->t('visit_site') . '</a>'; 
?>
<div class="p-4 hover:bg-green-500/10 transition-colors cursor-pointer group rounded-[2rem]"
    @click="copyToClipboard(<?= json_encode($htmlLink) ?>)">
    <p class="text-[9px] uppercase font-black mb-1 text-green-600/60 tracking-tighter ml-2 text-left">
        <?= $i18n->t('html_link') ?>
    </p>
    <div class="flex items-center justify-between px-2">
        <input type="text" readonly 
            value="<?= htmlspecialchars($htmlLink, ENT_QUOTES) ?>" 
            class="w-full bg-transparent outline-none text-left font-mono text-[11px] text-slate-500 cursor-pointer">
        <span class="text-green-600 group-hover:scale-110 transition-transform ml-2 italic text-[10px] font-bold">HTML</span>
    </div>
</div>

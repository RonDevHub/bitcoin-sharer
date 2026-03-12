<?php
namespace App;

class Renderer {
    public static function render(string $viewData, bool $error, ?string $generatedLink, I18n $i18n, string $qrOutput = ""): void {
        $lang = $i18n->getLang();
        include __DIR__ . '/../public/template.php';
    }
}
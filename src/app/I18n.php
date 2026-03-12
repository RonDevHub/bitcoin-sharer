<?php
namespace App;

class I18n {
    private array $texts;
    private string $currentLang;

    public function __construct() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
        $this->currentLang = in_array($lang, ['de', 'en']) ? $lang : 'en';
        
        $path = __DIR__ . "/../lang/{$this->currentLang}.json";
        $this->texts = json_decode(file_get_contents($path), true);
    }

    public function t(string $key): string {
        return $this->texts[$key] ?? $key;
    }

    public function getLang(): string {
        return $this->currentLang;
    }
}
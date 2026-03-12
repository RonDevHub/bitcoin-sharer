<?php
namespace App;

class I18n {
    private array $texts;
    private string $currentLang;

    public function __construct() {
        // Erkennt 'de', 'en', etc. aus dem Header
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
        $this->currentLang = in_array($browserLang, ['de', 'en']) ? $browserLang : 'en';
        
        // Fix für Pfad im Docker-Container
        $path = __DIR__ . "/../lang/" . $this->currentLang . ".json";
        
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $this->texts = json_decode($content, true) ?: [];
        } else {
            // Absoluter Notfall-Fallback
            $this->texts = ['title' => 'BTC Sharer'];
        }
    }

    public function t(string $key): string {
        return $this->texts[$key] ?? $key;
    }

    public function getLang(): string {
        return $this->currentLang;
    }
}
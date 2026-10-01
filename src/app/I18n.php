<?php
namespace App;

class I18n {
    private array $texts = [];
    private string $currentLang = 'en';
    private string $fallbackLang = 'en';

    public function __construct(?string $overrideLang = null) {
        $langDir = __DIR__ . '/../lang/';

        // 1. Alle verfügbaren Sprachen anhand der vorhandenen JSON-Dateien ermitteln
        $supportedLangs = [];
        if (is_dir($langDir)) {
            $files = glob($langDir . '*.json');
            foreach ($files as $file) {
                $supportedLangs[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        // Standard-Fallback setzen, falls gar keine Sprachdateien da sind
        if (empty($supportedLangs)) {
            $supportedLangs = ['en'];
        }

        // 2. Sprache ermitteln (Entweder explizit übergeben, per GET-Parameter, Cookie oder Header)
        $lang = $overrideLang ?? $_GET['lang'] ?? null;

        if (!$lang) {
            // Aus HTTP_ACCEPT_LANGUAGE (z.B. "de-DE,de;q=0.9,uk;q=0.8") die primäre Sprache extrahieren
            $browserLang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? $this->fallbackLang, 0, 2));
            $lang = $browserLang;
        }

        // 3. Prüfen, ob die gewählte Sprache unterstützt wird, sonst Fallback
        $this->currentLang = in_array($lang, $supportedLangs, true) ? $lang : $this->fallbackLang;

        // 4. Sprachdatei laden
        $path = $langDir . $this->currentLang . ".json";
        
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $this->texts = json_decode($content, true) ?: [];
        } else {
            // Notfall-Fallback
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
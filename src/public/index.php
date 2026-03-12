<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Crypto;
use App\I18n;
use App\Renderer;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$appKey = getenv('APP_KEY') ?: 'base64:unsecure-fallback-key-replace-me';
$crypto = new Crypto($appKey);
$i18n = new I18n();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$viewData = null;
$error = false;
$validationError = false;
$generatedLink = null;
$qrOutput = "";

// LOGIK: Link Generierung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['address'])) {
    $inputAddress = trim($_POST['address']);
    
    // Bitcoin Regex: Legacy, P2SH, SegWit/Taproot (bc1...)
    $btcRegex = '/^(1[a-km-zA-HJ-NP-Z1-9]{25,34}|3[a-km-zA-HJ-NP-Z1-9]{25,34}|bc1[a-zA-HJ-NP-Z0-9]{25,90})$/i';
    
    if (preg_match($btcRegex, $inputAddress)) {
        $encrypted = $crypto->encrypt($inputAddress);
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $generatedLink = $protocol . $_SERVER['HTTP_HOST'] . "/v/" . $encrypted;
        $validationError = false; // Zurücksetzen bei Erfolg
    } else {
        $validationError = true;
        $generatedLink = null; // Alten Link bei Fehler löschen
    }
}

// LOGIK: Link Anzeige (View)
if (str_starts_with($uri, '/v/')) {
    $hash = substr($uri, 3);
    $viewData = $crypto->decrypt($hash);
    
    if (!$viewData) {
        $error = true;
    } else {
        $options = new QROptions([
            'outputType'     => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'       => QRCode::ECC_L,
            'imageBase64'    => false,
            'xmlDeclaration' => false, 
            'addQuietzone'   => true,
        ]);
        $qrOutput = (new QRCode($options))->render($viewData);
    }
}

Renderer::render((string)$viewData, $error, $generatedLink, $i18n, $qrOutput, $validationError);
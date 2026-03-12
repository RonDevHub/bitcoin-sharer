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
$generatedLink = null;
$qrOutput = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['address'])) {
    $encrypted = $crypto->encrypt(trim($_POST['address']));
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $generatedLink = $protocol . $_SERVER['HTTP_HOST'] . "/v/" . $encrypted;
}

if (str_starts_with($uri, '/v/')) {
    $hash = substr($uri, 3);
    $viewData = $crypto->decrypt($hash);
    if (!$viewData) {
        $error = true;
    } else {
        $options = new QROptions(['outputType' => QRCode::OUTPUT_MARKUP_SVG, 'eccLevel' => QRCode::ECC_L]);
        $qrOutput = (new QRCode($options))->render($viewData);
    }
}

Renderer::render((string)$viewData, $error, $generatedLink, $i18n, $qrOutput);
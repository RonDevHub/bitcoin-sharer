<?php
namespace App;

class Crypto {
    private string $key;
    private string $method = 'aes-256-gcm';

    public function __construct(string $key) {
        $this->key = hash('sha256', $key, true);
    }

    public function encrypt(string $data): string {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
        $encrypted = openssl_encrypt($data, $this->method, $this->key, 0, $iv, $tag);
        // Format: IV + TAG + DATA (Base64 URL Safe)
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($iv . $tag . $encrypted));
    }

    public function decrypt(string $payload): ?string {
        $decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload));
        $ivLen = openssl_cipher_iv_length($this->method);
        $tagLen = 16;
        
        $iv = substr($decoded, 0, $ivLen);
        $tag = substr($decoded, $ivLen, $tagLen);
        $ciphertext = substr($decoded, $ivLen + $tagLen);

        $decrypted = openssl_decrypt($ciphertext, $this->method, $this->key, 0, $iv, $tag);
        return $decrypted ?: null;
    }
}
# ₿ Bitcoin-Sharer

<div align="center">
  
![Created](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/created-at/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/lastcommit/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/stars/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/issues/*/*/de) ![GitHub Repo language](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/language/*/*/de) ![GitHub Repo license](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/license/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/release/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/forks/*/*/de) ![GitHub Repo downlods](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/downloads/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/watchers) ![Build Status](https://github.com/RonDevHub/bitcoin-sharer/actions/workflows/docker-publish.yml/badge.svg)

[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/Buy_me_a_Coffee-c1d82f-222/social "Buy me a coffee")](https://www.buymeacoffee.com/RonDev)
[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/ko--fi.com-c1d82f-222/social "Buy me a coffee")](https://ko-fi.com/U6U31EV2VS)
[![Sponsor me](https://mini-badges.rondevhub.de/icon/hearts-red/Sponsor_me/social "Sponsor me")](https://github.com/sponsors/RonDevHub)
[![Pizza Power](https://mini-badges.rondevhub.de/icon/pizzaslice/Buy_me_a_pizza/social "Pizza Power")](https://www.paypal.com/paypalme/Depressionist1/4,99)
</div>
<hr>

Ein minimalistischer, ressourcensparender PHP-Dienst zum anonymen Teilen von Bitcoin-Adressen.

## Features
- **Stateless:** Keine Datenbank, keine Speicherung von Adressen.
- **Privacy:** Nginx-Logs sind deaktiviert. Die Adresse existiert nur im verschlüsselten Link.
- **Sicherheit:** AES-256-GCM Verschlüsselung schützt vor Manipulation.
- **Design:** Modernes UI mit Tailwind CSS, Dark/Light Mode und QR-Code.
- **Leichtgewicht:** Basiert auf PHP 8.3 Alpine (~50MB Image).

## Installation (Docker)
1. Erstelle ein `docker-compose.yml` (siehe unten).
2. Setze einen eigenen `APP_KEY` in den Environment-Variablen.
3. Starte den Stack: `docker compose up -d`.

## Environment Variables
- `APP_KEY`: Ein geheimer String zur Verschlüsselung der Adressen.

---

# ₿ Bitcoin-Sharer (English)

A minimalist, resource-efficient PHP service for sharing Bitcoin addresses anonymously.

## Features
- **Stateless:** No database, no address storage.
- **Privacy:** Nginx logs are disabled. The address only exists within the encrypted link.
- **Security:** AES-256-GCM encryption prevents tampering.
- **Design:** Modern UI with Tailwind CSS, Dark/Light Mode, and QR codes.
- **Lightweight:** Based on PHP 8.3 Alpine (~50MB image).
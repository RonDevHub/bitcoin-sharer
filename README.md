# ₿ Bitcoin-Sharer

<div align="center">
  
![Created](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/created-at/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/lastcommit/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/stars/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/issues/*/*/de) ![GitHub Repo language](https://mini-badges.rondevhub.de/forgejo/RonDevHub/bitcoin-sharer/language/*/*/de) ![GitHub Repo license](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/license/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/release/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/forks/*/*/de) ![GitHub Repo downlods](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/downloads/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/bitcoin-sharer/watchers) ![Build Status](https://github.com/RonDevHub/bitcoin-sharer/actions/workflows/docker-publish.yml/badge.svg)

[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/Buy_me_a_Coffee-c1d82f-222/social "Buy me a coffee")](https://www.buymeacoffee.com/RonDev)
[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/ko--fi.com-c1d82f-222/social "Buy me a coffee")](https://ko-fi.com/U6U31EV2VS)
[![Sponsor me](https://mini-badges.rondevhub.de/icon/hearts-red/Sponsor_me/social "Sponsor me")](https://github.com/sponsors/RonDevHub)
[![Pizza Power](https://mini-badges.rondevhub.de/icon/pizzaslice/Buy_me_a_pizza/social "Pizza Power")](https://www.paypal.com/paypalme/Depressionist1/4,99)
[![Bitcoin Power](https://mini-badges.rondevhub.de/icon/bitcoin/Bitcoin-ff7b00/social/-666666 "Bitcoin Power")](https://btc-sharer.s3cr.net/v/Vv7pQfYHW3HDqOkKujhGo8DOokNoA9FD_v3pyzFLMHZKR1gyTFJRQ1A5RWZmM09hTjI5SFZsY2ZlQThGWVZPazBnbHczaTJ6UzVWZVVGcnYwMWEr)
</div>
<hr>

[English Version below](#english)

Ein minimalistischer, hochsicherer und privatsphären-fokussierter Webdienst zum Teilen von Bitcoin-Adressen. Dieses Projekt verfolgt einen **Stateless-Ansatz**: Es gibt keine Datenbank, keine Protokollierung und keine Speicherung von Nutzerdaten.

## 🌟 Features

- **Absoluter Datenschutz (Zero-Knowledge):** Keine Datenbank erforderlich. Die Bitcoin-Adresse wird verschlüsselt direkt in der URL gespeichert.
- **Manipulationsschutz:** Nutzt modernste kryptografische Verfahren (**AES-256-GCM**). Wenn auch nur ein Zeichen am Link geändert wird, erkennt das System die Manipulation und verweigert die Anzeige.
- **Ressourcenschonend:** Optimiert für kleine Homelabs (z.B. Laptops mit wenig RAM). Basiert auf PHP 8.3 Alpine Linux.
- **Modernes Design:** Clean UI mit Tailwind CSS und Alpine.js.
- **Auto-Darkmode:** Erkennt das System-Design automatisch, kann aber manuell umgeschaltet werden.
- **Multilingual:** Automatische Erkennung von Deutsch und Englisch.
- **SEO-Optimiert:** Startseite ist für Suchmaschinen optimiert, während geteilte Links (`/v/`) strikt von der Indexierung ausgeschlossen sind (`noindex`).
- **Privatsphäre-Konfiguration:** Vorkonfigurierter Nginx, der keine Access-Logs schreibt.

## 🛠 Installation & Deployment

Das Projekt ist vollständig dockerisiert und optimiert für die Nutzung mit **Portainer** und **Cloudflare Tunneln**.

### Voraussetzungen
- Docker & Docker Compose

### Docker Compose
```yaml
services:
  bitcoin-sharer:
    image: ghcr.io/rondevhub/bitcoin-sharer:latest
    container_name: btc-sharer
    restart: unless-stopped
    ports:
      - "8080:80"
    environment:
      - APP_KEY=DEIN_GEHEIMER_KEY_HIER # Ersetze dies durch einen langen, zufälligen String
```
**Wichtig:** Der `APP_KEY` ist der Master-Schlüssel für die Verschlüsselung. Wenn du diesen Schlüssel änderst, werden alle zuvor generierten Links ungültig.

## 🔒 Sicherheitshinweise
Da dieses Projekt keine Logs schreibt, hat selbst der Administrator keine Einsicht darüber, welche Adressen geteilt werden. Die Sicherheit basiert rein auf der Geheimhaltung deines APP_KEY. Die Anwendung validiert Bitcoin-Adressen (Legacy, SegWit, Taproot) vor der Link-Erstellung, um Fehlbedienungen zu vermeiden.

---

Entwickelt von Ronny (rondevhub)

<a name="english"></a>
# ₿ Bitcoin-Sharer (English)

A minimalist, high-security, and privacy-focused web service for sharing Bitcoin addresses. This project follows a **stateless approach**: no database, no logging, and no storage of user data.

## 🌟 Features

- **Absolute Privacy (Zero-Knowledge):** No database required. The Bitcoin address is encrypted and stored directly within the URL.
- **Tamper Protection:** Utilizes state-of-the-art cryptography **(AES-256-GCM)**. If even a single character in the link is changed, the system detects the manipulation and refuses to display the address.
- **Resource Efficient:** Optimized for small home labs (e.g., laptops with limited RAM). Based on PHP 8.3 Alpine Linux.
- **Modern Design:** Clean UI built with Tailwind CSS and Alpine.js.
- **Auto Dark Mode:** Automatically detects system theme, with a manual toggle option.
- **Multilingual:** Auto-detects German and English.
- **SEO Optimized:** The landing page is search engine optimized, while shared links (`/v/`) are strictly excluded from indexing (noindex).
- **Privacy Configuration:** Pre-configured Nginx that does not write access logs.

## 🛠 Installation & Deployment
The project is fully dockerized and optimized for use with Portainer and Cloudflare Tunnels.

### Prerequisites
- Docker & Docker Compose

### Docker Compose
```yaml
services:
  bitcoin-sharer:
    image: ghcr.io/rondevhub/bitcoin-sharer:latest
    container_name: btc-sharer
    restart: unless-stopped
    ports:
      - "8080:80"
    environment:
      - APP_KEY=DEIN_GEHEIMER_KEY_HIER # Replace this with a long, random string
```
**Important:** The `APP_KEY` is the master key for encryption. If you change this key, all previously generated links will become invalid.

## 🔒 Security Notes
Since this project does not write logs, even the administrator has no insight into which addresses are being shared. Security is based entirely on the secrecy of your APP_KEY. The application validates Bitcoin addresses (Legacy, SegWit, Taproot) before link creation to prevent errors.

---

Developed by Ronny (rondevhub)
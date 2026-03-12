# ₿ Bitcoin-Sharer

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
# Changelog

## UI-Anpassungen
- generierte Links werden nun übersichtlicher angezeigt
- Favicon hinzugefügt
- Docker Images für `linux/amd64,linux/arm64` hinzugefügt
- dynamische Meta-Tags hinzugefügt, SEO-Content wird nur auf der Startseite angezeigt, die Viewseite wird von der Indexierung ausgeschlossen
  
## Sicherheit
- kleine Sicherheitsprüfung für den `APP_KEY` eingebaut
- die HTTPS-Erkennung so eingebaut, dass sie sowohl lokal als auch hinter deinem Cloudflare-Tunnel (`via X-Forwarded-Proto`) zuverlässig funktioniert
- `SERVER_PORT == 443`: zusätzlicher Sicherheitscheck, für direktes SSL ohne Proxy

# KFZ-Steuer Rechner

Eine moderne, responsive Webseite zur Berechnung der deutschen Kraftfahrzeugsteuer. Entwickelt mit Astro, Svelte, Tailwind CSS und PHP Backend.

## 🚗 Features

- **Präzise Berechnung** der deutschen KFZ-Steuer nach aktuellen Gesetzen (2025)
- **Alle Fahrzeugtypen** unterstützt: Benziner, Diesel, Hybrid, Elektro
- **Mobile-First Design** mit Tailwind CSS
- **SEO-optimiert** mit strukturierten Daten
- **Schnelle Performance** durch Astro Static Site Generation
- **PHP Backend** für erweiterte Berechnungen
- **DSGVO-konform** - keine Datenspeicherung

## 🛠️ Technologie-Stack

### Frontend
- **Astro** - Static Site Generator
- **Svelte** - Reaktive UI-Komponenten  
- **TypeScript** - Type-sichere Entwicklung
- **Tailwind CSS** - Utility-First CSS Framework
- **SASS** - CSS-Präprozessor

### Backend
- **PHP** - Server-seitige Berechnungen
- **REST API** - JSON-basierte Kommunikation

### Build Tools
- **Vite** - Schneller Build-Prozess
- **PostCSS** - CSS-Verarbeitung

## 🚀 Installation

### Voraussetzungen
- Node.js (Version 16 oder höher)
- PHP (Version 7.4 oder höher)
- npm oder yarn

### Setup

1. **Repository klonen**
   ```bash
   git clone <repository-url>
   cd kfz-rechner
   ```

2. **Frontend-Abhängigkeiten installieren**
   ```bash
   npm install
   ```

3. **Entwicklungsserver starten**
   ```bash
   # Frontend (Port 3000)
   npm run dev
   
   # PHP Backend (Port 8080) - in separatem Terminal
   npm run php:start
   ```

4. **Website öffnen**
   ```
   http://localhost:3000
   ```

## 📁 Projektstruktur

```
kfz-rechner/
├── src/
│   ├── components/          # Svelte-Komponenten
│   │   ├── Calculator.svelte
│   │   ├── Hero.svelte
│   │   ├── Features.svelte
│   │   └── Footer.svelte
│   ├── layouts/            # Astro-Layouts
│   │   └── Layout.astro
│   ├── pages/              # Astro-Seiten
│   │   ├── index.astro
│   │   ├── impressum.astro
│   │   └── datenschutz.astro
│   └── styles/             # SCSS-Styles
│       ├── variables.scss
│       └── global.scss
├── backend/                # PHP Backend
│   ├── calculate-tax.php   # API-Endpoint
│   └── index.html         # API-Dokumentation
├── public/                 # Statische Assets
├── astro.config.mjs       # Astro-Konfiguration
├── tailwind.config.js     # Tailwind-Konfiguration
├── tsconfig.json          # TypeScript-Konfiguration
└── package.json           # Node.js-Abhängigkeiten
```

## 🧮 KFZ-Steuer Berechnung

### Berechnungsgrundlagen (2025)

#### Hubraumsteuer
- **Benziner:** 2,00 € je angefangene 100 ccm
- **Diesel:** 9,50 € je angefangene 100 ccm

#### CO2-Steuer (ab Erstzulassung 2009)
Gestaffelte Besteuerung über 95 g/km Freibetrag:
- 0-15 g/km: 2,00 € je g/km
- 16-35 g/km: 2,20 € je g/km  
- 36-55 g/km: 2,50 € je g/km
- 56-75 g/km: 2,90 € je g/km
- 76-95 g/km: 3,40 € je g/km
- >95 g/km: 4,00 € je g/km

#### Sonderregelungen
- **Elektrofahrzeuge:** Steuerbefreit
- **Hybridfahrzeuge:** 50% Steuerermäßigung
- **Mindeststeuer:** 20 € pro Jahr

## 🔧 Entwicklung

### Verfügbare Scripts

```bash
# Entwicklung starten
npm run dev

# Frontend build
npm run build

# Preview der gebauten Site
npm run preview

# PHP Backend starten
npm run php:start

# TypeScript prüfen
npm run check

# TypeScript im Watch-Modus
npm run check:watch
```

### Code-Qualität

Das Projekt verwendet:
- **TypeScript** für Type-Sicherheit
- **Svelte-Check** für Svelte-Komponenten-Validierung
- **ESLint/Prettier** (empfohlen) für Code-Formatierung

### Browser-Unterstützung

- **Modern Browsers:** Chrome 88+, Firefox 85+, Safari 14+, Edge 88+
- **Mobile:** iOS Safari 14+, Chrome Mobile 88+

## 🌐 Deployment

### Static Hosting (empfohlen)
1. Build erstellen: `npm run build`
2. `dist/` Ordner auf statischen Host hochladen
3. PHP Backend separat deployen

### Vercel/Netlify
- Automatisches Deployment über Git
- Serverless Functions für PHP-Alternative

### Traditionelles Hosting
- `dist/` für Frontend
- `backend/` für PHP-API
- Webserver-Konfiguration für SPA-Routing

## 📝 API-Dokumentation

### POST /api/calculate-tax.php

**Request:**
```json
{
  "type": "benzin|diesel|elektro|hybrid",
  "displacement": 1600,
  "co2_emission": 120,
  "first_registration_year": 2020,
  "weight": 1500
}
```

**Response:**
```json
{
  "annual": 164.00,
  "monthly": 13.67,
  "details": {
    "displacement_tax": 32.00,
    "co2_tax": 50.00,
    "base_tax": 0.00
  }
}
```

## 🔍 SEO & Strukturierte Daten

- Die wichtigsten FAQs werden sowohl auf der Startseite (als Accordion) als auch auf einer eigenen FAQ-Seite angezeigt.
- Für optimale Sichtbarkeit in Google & Co. werden strukturierte FAQ-Daten (JSON-LD nach schema.org) im <head> der Startseite und FAQ-Seite eingebunden.
- So erscheinen die Fragen als Rich Snippet in den Suchergebnissen und verbessern die Klickrate.

**Tipp:** Eigene FAQ-Seite und FAQ-Accordion auf der Startseite kombinieren – das ist Best Practice für SEO!

## 🔒 Datenschutz

- **Keine Datenspeicherung:** Fahrzeugdaten werden nicht gespeichert
- **Lokale Berechnung:** Fallback-Berechnung im Browser
- **Temporäre API-Calls:** Daten werden nach Berechnung gelöscht
- **DSGVO-konform:** Minimale Datenverarbeitung

## 📄 Lizenz

Dieses Projekt steht unter der MIT-Lizenz. Siehe [LICENSE](LICENSE) für Details.

## 🤝 Beitragen

1. Fork des Repositories
2. Feature-Branch erstellen (`git checkout -b feature/amazing-feature`)
3. Änderungen committen (`git commit -m 'Add amazing feature'`)
4. Branch pushen (`git push origin feature/amazing-feature`)
5. Pull Request erstellen

## 📞 Support

Bei Fragen oder Problemen:
- **Issues:** GitHub Issues verwenden
- **E-Mail:** [Ihre E-Mail-Adresse]
- **Dokumentation:** Siehe `/backend/index.html` für API-Details

## 🚨 Rechtlicher Hinweis

Alle Berechnungen erfolgen nach bestem Wissen und Gewissen basierend auf den aktuellen deutschen Steuergesetzen. Für verbindliche Auskünfte wenden Sie sich an Ihr zuständiges Finanzamt oder einen Steuerberater.

---

**Made with ❤️ for German car owners**

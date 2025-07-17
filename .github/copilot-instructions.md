<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# KFZ-Steuer Rechner - Copilot Instructions

## Projekt-Kontext
Dies ist ein moderner KFZ-Steuer Rechner für Deutschland, entwickelt mit Astro, Svelte, TypeScript, Tailwind CSS und PHP Backend.

## Technologie-Stack
- **Frontend:** Astro + Svelte + TypeScript + Tailwind CSS + SASS
- **Backend:** PHP REST API
- **Build:** Vite + PostCSS
- **Styling:** Tailwind CSS (utility-first) + SASS (variables/mixins)

## Code-Stil & Konventionen

### TypeScript/JavaScript
- Verwende TypeScript für alle neuen Dateien
- Nutze moderne ES6+ Features
- Bevorzuge `const` und `let` statt `var`
- Verwende aussagekräftige Variablen- und Funktionsnamen auf Deutsch
- Kommentiere komplexe Berechnungen, besonders Steuer-Logik

### Svelte
- Nutze `<script lang="ts">` für TypeScript
- Verwende reactive statements (`$:`) für berechnete Werte
- Strukturiere Komponenten: Script, Markup, Style
- Nutze Svelte-spezifische Features (stores, actions, transitions)

### Styling
- **Primär:** Tailwind CSS Utility-Classes
- **Sekundär:** SASS für komplexe Styles und Variablen
- Mobile-First Approach
- Nutze Tailwind-Konfiguration für Farben und Spacing
- Verwende semantic CSS-Klassen für wiederverwendbare Komponenten

### PHP
- Verwende moderne PHP-Syntax (7.4+)
- Nutze Type-Hints wo möglich
- Implementiere proper error handling
- Folge PSR-Standards für Code-Struktur
- Kommentiere Steuer-Berechnungslogik ausführlich

## Spezifische Anforderungen

### KFZ-Steuer Berechnung
- Implementiere aktuelle deutsche Steuergesetze (2025)
- Berücksichtige alle Fahrzeugtypen: Benzin, Diesel, Hybrid, Elektro
- Berechne Hubraumsteuer und CO2-Steuer separat
- Dokumentiere alle Berechnungsschritte

### Benutzerfreundlichkeit
- Responsive Design für alle Bildschirmgrößen
- Intuitive Eingabefelder mit Validierung
- Sofortige Fehlerbehandlung und Feedback
- Klare Ergebnisdarstellung mit Aufschlüsselung

### Performance
- Nutze Astro's Static Site Generation
- Minimiere JavaScript-Bundle-Größe
- Optimiere Bilder und Assets
- Implementiere lazy loading wo sinnvoll

### SEO & Accessibility
- Strukturierte Daten (JSON-LD)
- Semantic HTML
- Alt-Tags für Bilder
- ARIA-Labels für Formularelemente
- Deutsch als Hauptsprache

## Naming Conventions
- **Dateien:** kebab-case (`kfz-rechner.ts`)
- **Komponenten:** PascalCase (`Calculator.svelte`)
- **Variablen:** camelCase (`vehicleType`)
- **Konstanten:** UPPER_CASE (`TAX_RATES`)
- **CSS-Klassen:** Tailwind utilities + BEM für custom classes

## Debugging & Testing
- Nutze Browser DevTools für Frontend-Debugging
- Teste API-Endpoints mit verschiedenen Eingabedaten
- Validiere Berechnungen mit offiziellen Steuerrechner-Ergebnissen
- Teste auf verschiedenen Geräten und Browsern

## Rechtliche Hinweise
- Alle Berechnungen sind unverbindlich
- Weise auf offizielle Quellen hin
- Implementiere Datenschutz-konforme Datenverarbeitung
- Keine Speicherung von Benutzerdaten

## Hilfreiche Ressourcen
- Deutsche Steuergesetze: KraftStG, KraftStDV
- Astro Documentation: https://docs.astro.build/
- Svelte Documentation: https://svelte.dev/docs
- Tailwind CSS: https://tailwindcss.com/docs

Bei Fragen zur KFZ-Steuer-Berechnung, konsultiere die aktuellen deutschen Steuergesetze und -verordnungen.

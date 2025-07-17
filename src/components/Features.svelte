<script lang="ts">
  const features = [
    {
      title: "Präzise Berechnung",
      description: "Basierend auf den aktuellen deutschen Steuergesetzen für 2025",
      icon: "🎯"
    },
    {
      title: "Alle Fahrzeugtypen",
      description: "Benziner, Diesel, Hybrid und Elektrofahrzeuge werden unterstützt",
      icon: "🚗"
    },
    {
      title: "Sofortige Ergebnisse",
      description: "Berechnung in Echtzeit ohne Wartezeit",
      icon: "⚡"
    },
    {
      title: "Mobile optimiert",
      description: "Perfekt nutzbar auf allen Geräten und Bildschirmgrößen",
      icon: "📱"
    },
    {
      title: "Kostenlos",
      description: "Komplett kostenlos und ohne versteckte Gebühren",
      icon: "💰"
    },
    {
      title: "Datenschutz",
      description: "Ihre Daten werden nicht gespeichert oder weitergegeben",
      icon: "🔒"
    }
  ];
</script>

<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl sm:text-4xl font-display font-bold text-gray-900 mb-4">
          Warum unseren KFZ-Steuer Rechner nutzen?
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
          Unser Rechner bietet Ihnen alle Vorteile für eine schnelle und präzise Berechnung Ihrer Kraftfahrzeugsteuer.
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {#each features as feature}
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="text-4xl mb-4">{feature.icon}</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">
              {feature.title}
            </h3>
            <p class="text-gray-600 leading-relaxed">
              {feature.description}
            </p>
          </div>
        {/each}
      </div>
      
      <!-- Zusätzliche Informationen -->
      <div class="mt-16 bg-white rounded-2xl p-8 shadow-lg">
        <div class="max-w-4xl mx-auto">
          <h3 class="text-2xl font-display font-bold text-gray-900 mb-6 text-center">
            Wichtige Informationen zur KFZ-Steuer
          </h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">
                📋 Berechnungsgrundlagen
              </h4>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Hubraum in Kubikzentimetern (ccm)
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  CO2-Ausstoß in Gramm pro Kilometer
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Datum der Erstzulassung
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Zulässiges Gesamtgewicht
                </li>
              </ul>
            </div>
            
            <div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">
                💡 Steuersätze 2025
              </h4>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Benziner: 2,00 € je angefangene 100 ccm
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Diesel: 9,50 € je angefangene 100 ccm
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  CO2-Zuschlag: 2,00 € je g/km über 95 g/km
                </li>
                <li class="flex items-start">
                  <span class="text-primary-500 mr-2">•</span>
                  Elektrofahrzeuge: steuerbefreit
                </li>
              </ul>
            </div>
          </div>
          
          <div class="mt-8 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <p class="text-sm text-yellow-800">
              <strong>Rechtlicher Hinweis:</strong> Alle Berechnungen erfolgen nach bestem Wissen und Gewissen basierend auf den aktuellen Gesetzen. 
              Für verbindliche Auskünfte wenden Sie sich bitte an Ihr zuständiges Finanzamt oder einen Steuerberater.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

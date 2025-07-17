<script lang="ts">
  const currentYear = new Date().getFullYear();
  
  const footerLinks = {
    rechner: [
      { title: "KFZ-Steuer Rechner", href: "#rechner" },
      { title: "Steuer-Informationen", href: "#info" },
      { title: "FAQ", href: "#faq" }
    ],
    legal: [
      { title: "Impressum", href: "/impressum" },
      { title: "Datenschutz", href: "/datenschutz" },
      { title: "Kontakt", href: "/kontakt" }
    ]
  };
</script>

<footer class="bg-gray-900 text-white py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
      <!-- Hauptinhalt -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        <!-- Über uns -->
        <div class="lg:col-span-2">
          <h3 class="text-xl font-display font-bold mb-4">
            KFZ-Steuer Rechner
          </h3>
          <p class="text-gray-300 mb-4 leading-relaxed">
            Ihr kostenloser und zuverlässiger Online-Rechner für die deutsche Kraftfahrzeugsteuer. 
            Schnell, präzise und immer auf dem neuesten Stand der Gesetzgebung.
          </p>
          <div class="flex space-x-4">
            <a href="https://facebook.com" class="text-gray-400 hover:text-white transition-colors" rel="noopener noreferrer" target="_blank">
              <span class="sr-only">Facebook</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <a href="https://twitter.com" class="text-gray-400 hover:text-white transition-colors" rel="noopener noreferrer" target="_blank">
              <span class="sr-only">Twitter</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
              </svg>
            </a>
          </div>
        </div>
        
        <!-- Rechner Links -->
        <div>
          <h4 class="text-lg font-semibold mb-4">Rechner</h4>
          <ul class="space-y-2">
            {#each footerLinks.rechner as link}
              <li>
                <a href={link.href} class="text-gray-300 hover:text-white transition-colors">
                  {link.title}
                </a>
              </li>
            {/each}
          </ul>
        </div>
        
        <!-- Rechtliches -->
        <div>
          <h4 class="text-lg font-semibold mb-4">Rechtliches</h4>
          <ul class="space-y-2">
            {#each footerLinks.legal as link}
              <li>
                <a href={link.href} class="text-gray-300 hover:text-white transition-colors">
                  {link.title}
                </a>
              </li>
            {/each}
          </ul>
        </div>
      </div>
      
      <!-- Trennlinie -->
      <div class="border-t border-gray-800 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-gray-400 text-sm mb-4 md:mb-0">
            © {currentYear} KFZ-Steuer Rechner. Alle Rechte vorbehalten.
          </div>
          <div class="text-gray-400 text-sm">
            Gemacht mit ❤️ für deutsche Autofahrer
          </div>
        </div>
      </div>
      
      <!-- Disclaimer -->
      <div class="mt-6 p-4 bg-gray-800 rounded-lg">
        <p class="text-xs text-gray-400 text-center">
          <strong>Wichtiger Hinweis:</strong> Alle Berechnungen erfolgen ohne Gewähr. 
          Die angezeigten Steuerbeträge sind Schätzungen basierend auf den aktuellen Gesetzen. 
          Für verbindliche Auskünfte kontaktieren Sie bitte Ihr zuständiges Finanzamt.
        </p>
      </div>
    </div>
  </div>
</footer>

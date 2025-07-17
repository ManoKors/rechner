<script lang="ts">
  import { onMount } from 'svelte';
  
  // Typen für das Fahrzeug und die Berechnung
  interface Vehicle {
    type: 'benzin' | 'diesel' | 'elektro' | 'hybrid';
    displacement: number; // Hubraum in ccm
    co2Emission: number; // CO2-Ausstoß in g/km
    firstRegistration: Date;
    weight: number; // Zulässiges Gesamtgewicht in kg
  }
  
  interface TaxResult {
    annual: number;
    monthly: number;
    details: {
      displacementTax: number;
      co2Tax: number;
      baseTax: number;
    };
  }
  
  // Reaktive Variablen
  let vehicleType: Vehicle['type'] = 'benzin';
  let displacement = 1600;
  let co2Emission = 120;
  let firstRegistrationYear = 2020;
  let weight = 1500;
  let result: TaxResult | null = null;
  let isCalculating = false;
  let errors: Record<string, string> = {};
  
  // Validierung
  function validateInputs(): boolean {
    errors = {};
    
    if (displacement < 1 || displacement > 10000) {
      errors.displacement = 'Hubraum muss zwischen 1 und 10.000 ccm liegen';
    }
    
    if (co2Emission < 0 || co2Emission > 500) {
      errors.co2Emission = 'CO2-Ausstoß muss zwischen 0 und 500 g/km liegen';
    }
    
    if (firstRegistrationYear < 1990 || firstRegistrationYear > new Date().getFullYear()) {
      errors.firstRegistrationYear = 'Erstzulassung muss zwischen 1990 und heute liegen';
    }
    
    if (weight < 100 || weight > 50000) {
      errors.weight = 'Gewicht muss zwischen 100 und 50.000 kg liegen';
    }
    
    return Object.keys(errors).length === 0;
  }
  
  // KFZ-Steuer Berechnung (lokale Fallback-Berechnung)
  function calculateTaxLocal(): TaxResult {
    let displacementTax = 0;
    let co2Tax = 0;
    let baseTax = 0;
    
    // Hubraumsteuer
    if (vehicleType === 'benzin') {
      displacementTax = Math.ceil(displacement / 100) * 2;
    } else if (vehicleType === 'diesel') {
      displacementTax = Math.ceil(displacement / 100) * 9.5;
    }
    
    // CO2-Steuer (für Fahrzeuge ab 2012)
    if (firstRegistrationYear >= 2012 && co2Emission > 95) {
      co2Tax = (co2Emission - 95) * 2;
    }
    
    // Elektro- und Hybridfahrzeuge
    if (vehicleType === 'elektro') {
      baseTax = 0; // Elektrofahrzeuge sind steuerbefreit
    } else if (vehicleType === 'hybrid') {
      // Reduzierte Steuer für Hybride
      baseTax = (displacementTax + co2Tax) * 0.5;
      displacementTax = 0;
      co2Tax = 0;
    }
    
    const annual = baseTax + displacementTax + co2Tax;
    
    return {
      annual: Math.round(annual),
      monthly: Math.round(annual / 12 * 100) / 100,
      details: {
        displacementTax: Math.round(displacementTax),
        co2Tax: Math.round(co2Tax),
        baseTax: Math.round(baseTax)
      }
    };
  }
  
  // API-Aufruf für präzise Berechnung
  async function calculateTaxAPI(): Promise<TaxResult> {
    const response = await fetch('/api/calculate-tax.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        type: vehicleType,
        displacement,
        co2_emission: co2Emission,
        first_registration_year: firstRegistrationYear,
        weight
      })
    });
    
    if (!response.ok) {
      throw new Error('API-Fehler');
    }
    
    return await response.json();
  }
  
  async function logFrontendRequest(payload: any) {
    try {
      await fetch('/api/frontend-log.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
    } catch (e) {
      // Logging-Fehler ignorieren
    }
  }

  // Hauptberechnung
  async function calculateTax() {
    if (!validateInputs()) {
      return;
    }

    isCalculating = true;
    let usedApi = false;
    let localResult: TaxResult | null = null;
    let apiResult: TaxResult | null = null;
    let errorMsg: string | null = null;

    try {
      // Versuche zuerst die API-Berechnung
      apiResult = await calculateTaxAPI();
      result = apiResult;
      usedApi = true;
    } catch (error) {
      // Fallback auf lokale Berechnung
      console.warn('API nicht verfügbar, verwende lokale Berechnung:', error);
      localResult = calculateTaxLocal();
      result = localResult;
      usedApi = false;
      errorMsg = String(error);
    }

    // Logging: immer nach Berechnung
    await logFrontendRequest({
      input: {
        type: vehicleType,
        displacement,
        co2Emission,
        firstRegistrationYear,
        weight
      },
      result,
      usedApi,
      error: errorMsg
    });

    isCalculating = false;
  }
  
  // Event-Handler
  function handleInputChange() {
    result = null;
    errors = {};
  }
  
  onMount(() => {
    calculateTax();
  });
</script>

<section class="py-16 bg-white" id="rechner">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl sm:text-4xl font-display font-bold text-gray-900 mb-4">
          KFZ-Steuer berechnen
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Geben Sie die Daten Ihres Fahrzeugs ein und erhalten Sie sofort eine präzise Berechnung Ihrer Kraftfahrzeugsteuer.
        </p>
      </div>
      
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
          <!-- Fahrzeugtyp -->
          <div class="mb-8">
            <span id="vehicle-type-label" class="block text-sm font-semibold text-gray-700 mb-4">
              Fahrzeugtyp
            </span>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" role="group" aria-labelledby="vehicle-type-label">
              {#each [
                { value: 'benzin', label: 'Benziner', icon: '⛽' },
                { value: 'diesel', label: 'Diesel', icon: '🚗' },
                { value: 'hybrid', label: 'Hybrid', icon: '🔋' },
                { value: 'elektro', label: 'Elektro', icon: '⚡' }
              ] as type}
                <button
                  type="button"
                  class="p-4 rounded-xl border-2 transition-all duration-200 {vehicleType === type.value 
                    ? 'border-primary-500 bg-primary-50 text-primary-700' 
                    : 'border-gray-200 hover:border-gray-300 text-gray-700'}"
                  aria-pressed={vehicleType === type.value}
                  aria-label={type.label}
                  on:click={() => { vehicleType = type.value as Vehicle['type']; handleInputChange(); }}
                >
                  <div class="text-2xl mb-2">{type.icon}</div>
                  <div class="text-sm font-medium">{type.label}</div>
                </button>
              {/each}
            </div>
          </div>
          
          <!-- Eingabefelder -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Hubraum -->
            <div>
            <label for="displacement" class="block text-sm font-semibold text-gray-700 mb-2">
              Hubraum (ccm)
            </label>
              <input
                id="displacement"
                type="number"
                bind:value={displacement}
                on:input={handleInputChange}
                min="1"
                max="10000"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors {errors.displacement ? 'border-red-500' : ''}"
                placeholder="z.B. 1600"
              />
              {#if errors.displacement}
                <p class="mt-1 text-sm text-red-600">{errors.displacement}</p>
              {/if}
            </div>
            
            <!-- CO2-Ausstoß -->
            <div>
            <label for="co2" class="block text-sm font-semibold text-gray-700 mb-2">
              CO2-Ausstoß (g/km)
            </label>
              <input
                id="co2"
                type="number"
                bind:value={co2Emission}
                on:input={handleInputChange}
                min="0"
                max="500"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors {errors.co2Emission ? 'border-red-500' : ''}"
                placeholder="z.B. 120"
              />
              {#if errors.co2Emission}
                <p class="mt-1 text-sm text-red-600">{errors.co2Emission}</p>
              {/if}
            </div>
            
            <!-- Erstzulassung -->
            <div>
            <label for="registration" class="block text-sm font-semibold text-gray-700 mb-2">
              Erstzulassung (Jahr)
            </label>
              <input
                id="registration"
                type="number"
                bind:value={firstRegistrationYear}
                on:input={handleInputChange}
                min="1990"
                max={new Date().getFullYear()}
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors {errors.firstRegistrationYear ? 'border-red-500' : ''}"
                placeholder="z.B. 2020"
              />
              {#if errors.firstRegistrationYear}
                <p class="mt-1 text-sm text-red-600">{errors.firstRegistrationYear}</p>
              {/if}
            </div>
            
            <!-- Gewicht -->
            <div>
            <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
              Zul. Gesamtgewicht (kg)
            </label>
              <input
                id="weight"
                type="number"
                bind:value={weight}
                on:input={handleInputChange}
                min="100"
                max="50000"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors {errors.weight ? 'border-red-500' : ''}"
                placeholder="z.B. 1500"
              />
              {#if errors.weight}
                <p class="mt-1 text-sm text-red-600">{errors.weight}</p>
              {/if}
            </div>
          </div>
          
          <!-- Berechnen Button -->
          <div class="text-center mb-8">
            <button
              type="button"
              on:click={calculateTax}
              disabled={isCalculating || Object.keys(errors).length > 0}
              class="px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {#if isCalculating}
                <span class="inline-flex items-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Berechne...
                </span>
              {:else}
                KFZ-Steuer berechnen
              {/if}
            </button>
          </div>
          
          <!-- Ergebnis -->
          {#if result}
            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
              <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                Ihre KFZ-Steuer
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hauptergebnis -->
                <div class="text-center">
                  <div class="text-4xl font-bold text-primary-600 mb-2">
                    {result.annual.toLocaleString('de-DE')} €
                  </div>
                  <div class="text-gray-600 font-medium">pro Jahr</div>
                  <div class="text-lg text-gray-800 mt-2">
                    {result.monthly.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} € monatlich
                  </div>
                </div>
                
                <!-- Aufschlüsselung -->
                <div class="space-y-3">
                  <h4 class="font-semibold text-gray-800 mb-3">Steueraufschlüsselung:</h4>
                  
                  {#if result.details.displacementTax > 0}
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                      <span class="text-gray-600">Hubraumsteuer:</span>
                      <span class="font-medium">{result.details.displacementTax} €</span>
                    </div>
                  {/if}
                  
                  {#if result.details.co2Tax > 0}
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                      <span class="text-gray-600">CO2-Steuer:</span>
                      <span class="font-medium">{result.details.co2Tax} €</span>
                    </div>
                  {/if}
                  
                  {#if result.details.baseTax > 0}
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                      <span class="text-gray-600">Grundsteuer:</span>
                      <span class="font-medium">{result.details.baseTax} €</span>
                    </div>
                  {/if}
                  
                  {#if vehicleType === 'elektro'}
                    <div class="text-green-600 font-medium text-center py-2">
                      ⚡ Elektrofahrzeuge sind steuerbefreit!
                    </div>
                  {/if}
                </div>
              </div>
              
              <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                  <strong>Hinweis:</strong> Diese Berechnung erfolgt nach den aktuellen Steuersätzen für 2025. 
                  Die tatsächliche Steuer kann je nach weiteren Faktoren variieren. 
                  Für verbindliche Auskünfte wenden Sie sich an Ihr Finanzamt.
                </p>
              </div>
            </div>
          {/if}
        </div>
      </div>
    </div>
  </div>
</section>

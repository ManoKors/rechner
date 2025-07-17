<script lang="ts">
import { onMount } from 'svelte';
let stats: any = null;
let error = '';
let isLoading = true;

// Für spätere Bearbeitung der Rechnerdaten
let editableConfig = {
  minDisplacement: 1,
  maxDisplacement: 10000,
  minCO2: 0,
  maxCO2: 500,
  minYear: 1990,
  maxYear: new Date().getFullYear(),
  minWeight: 100,
  maxWeight: 50000
};

function saveConfig() {
  // Hier könnte ein API-Call stehen, um die Daten persistent zu speichern
  alert('Konfiguration gespeichert (Demo)');
}

onMount(async () => {
  try {
    const res = await fetch('/backend/stats.php');
    stats = await res.json();
    if (stats.error) error = stats.error;
  } catch (e) {
    error = 'Fehler beim Laden der Statistik.';
  }
  isLoading = false;
});
</script>

<section class="max-w-4xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
  {#if isLoading}
    <div>Lade Statistik...</div>
  {:else if error}
    <div class="text-red-600">{error}</div>
  {:else}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Zugriffsstatistik</h2>
        <div class="mb-2">Gesamtanfragen: <span class="font-bold">{stats.total}</span></div>
        <div class="mb-2">Fahrzeugtypen:</div>
        <ul class="ml-4 list-disc">
          <li>Benzin: {stats.byType.benzin}</li>
          <li>Diesel: {stats.byType.diesel}</li>
          <li>Hybrid: {stats.byType.hybrid}</li>
          <li>Elektro: {stats.byType.elektro}</li>
        </ul>
        <div class="mt-4">
          <h3 class="font-semibold mb-2">Anfragen pro Tag</h3>
          <ul class="ml-4 list-disc">
            {#each Object.entries(stats.byDay) as [day, count]}
              <li>{day}: {count}</li>
            {/each}
          </ul>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Letzte Anfragen</h2>
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b">
              <th class="py-1">Zeit</th>
              <th>Typ</th>
              <th>Hubraum</th>
              <th>CO₂</th>
              <th>Jahr</th>
              <th>Gewicht</th>
              <th>Ergebnis</th>
            </tr>
          </thead>
          <tbody>
            {#each stats.lastRequests as req}
              <tr class="border-b">
                <td class="py-1">{req.time.slice(0,16).replace('T',' ')}</td>
                <td>{req.type}</td>
                <td>{req.displacement}</td>
                <td>{req.co2_emission}</td>
                <td>{req.first_registration_year}</td>
                <td>{req.weight}</td>
                <td>{req.result} €</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 mb-12">
      <h2 class="text-xl font-semibold mb-4">Rechner-Konfiguration</h2>
      <form on:submit|preventDefault={saveConfig} class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
          <label for="minDisplacement" class="block text-xs font-semibold mb-1">Min. Hubraum</label>
          <input id="minDisplacement" type="number" bind:value={editableConfig.minDisplacement} class="w-full border rounded px-2 py-1" min="1" max="10000" />
        </div>
        <div>
          <label for="maxDisplacement" class="block text-xs font-semibold mb-1">Max. Hubraum</label>
          <input id="maxDisplacement" type="number" bind:value={editableConfig.maxDisplacement} class="w-full border rounded px-2 py-1" min="1" max="10000" />
        </div>
        <div>
          <label for="minCO2" class="block text-xs font-semibold mb-1">Min. CO₂</label>
          <input id="minCO2" type="number" bind:value={editableConfig.minCO2} class="w-full border rounded px-2 py-1" min="0" max="500" />
        </div>
        <div>
          <label for="maxCO2" class="block text-xs font-semibold mb-1">Max. CO₂</label>
          <input id="maxCO2" type="number" bind:value={editableConfig.maxCO2} class="w-full border rounded px-2 py-1" min="0" max="500" />
        </div>
        <div>
          <label for="minYear" class="block text-xs font-semibold mb-1">Min. Jahr</label>
          <input id="minYear" type="number" bind:value={editableConfig.minYear} class="w-full border rounded px-2 py-1" min="1990" max={editableConfig.maxYear} />
        </div>
        <div>
          <label for="maxYear" class="block text-xs font-semibold mb-1">Max. Jahr</label>
          <input id="maxYear" type="number" bind:value={editableConfig.maxYear} class="w-full border rounded px-2 py-1" min={editableConfig.minYear} max={new Date().getFullYear()} />
        </div>
        <div>
          <label for="minWeight" class="block text-xs font-semibold mb-1">Min. Gewicht</label>
          <input id="minWeight" type="number" bind:value={editableConfig.minWeight} class="w-full border rounded px-2 py-1" min="100" max="50000" />
        </div>
        <div>
          <label for="maxWeight" class="block text-xs font-semibold mb-1">Max. Gewicht</label>
          <input id="maxWeight" type="number" bind:value={editableConfig.maxWeight} class="w-full border rounded px-2 py-1" min="100" max="50000" />
        </div>
        <div class="col-span-2 md:col-span-4 mt-4">
          <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Speichern</button>
        </div>
      </form>
      <p class="text-xs text-gray-500 mt-2">(Diese Einstellungen sind aktuell nur lokal und werden nicht gespeichert.)</p>
    </div>
  {/if}
</section>

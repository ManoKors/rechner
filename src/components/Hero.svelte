<script lang="ts">
  import { onMount } from 'svelte';
  
  let mounted = false;
  
  onMount(() => {
    mounted = true;
  });
</script>

<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white py-20 lg:py-32">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold mb-6 animate-fade-in">
        KFZ-Steuer Rechner
      </h1>
      <p class="text-xl sm:text-2xl text-primary-100 mb-8 max-w-3xl mx-auto animate-slide-up">
        Berechnen Sie schnell und einfach Ihre deutsche Kraftfahrzeugsteuer. 
        Kostenlos, präzise und aktuell nach den neuesten Gesetzen.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-slide-up">
        <div class="flex items-center space-x-2 text-primary-100">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>100% kostenlos</span>
        </div>
        <div class="flex items-center space-x-2 text-primary-100">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Aktuelle Steuersätze 2025</span>
        </div>
        <div class="flex items-center space-x-2 text-primary-100">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span>Sofortige Berechnung</span>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Decorative elements -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
  </div>
</section>

<style>
  .container {
    position: relative;
    z-index: 10;
  }
</style>

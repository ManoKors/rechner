<script context="module" lang="ts">
  // Typ nur im Modul-Kontext deklarieren
  export type FaqItem = {
    question: string;
    answer: string;
    id: string;
  };
</script>
<script lang="ts">
  import { writable } from 'svelte/store';
  const openIndex = writable<number | null>(null);
  export let faqs: FaqItem[] = [];
</script>

<section class="max-w-3xl mx-auto py-12 px-4">
  <h2 class="text-2xl font-bold mb-8 text-center">Häufige Fragen zur KFZ-Steuer</h2>
  <div class="mt-4 grid gap-6">
    {#each faqs as faq, i}
      <div class="faq">
        <button
          type="button"
          class="flex w-full gap-2 border-none bg-transparent p-0 text-left"
          aria-expanded={($openIndex === i) ? 'true' : 'false'}
          aria-controls={faq.id}
          on:click={() => $openIndex === i ? openIndex.set(null) : openIndex.set(i)}
        >
          <svg width="1.4rem" height="1.4rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="none" class="arrow-down shrink-0 translate-y-[0.15rem] transition-transform" aria-hidden="true" style:transform={$openIndex === i ? 'rotate(0deg)' : 'rotate(90deg)'}>
            <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" fill="#2563eb"/></svg>
          <h3 id={"faq-question-" + faq.id} class="question mb-0 font-semibold text-lg text-primary-800">{faq.question}</h3>
        </button>
        <div class="grid grid-rows-[1fr]">
          <div id={faq.id} class="overflow-hidden" role="region" aria-labelledby={"faq-question-" + faq.id} style="height: {$openIndex === i ? 'auto' : '0px'}; display: {$openIndex === i ? 'block' : 'none'};">
            <div class="html-content answer object-contain pt-2 prose prose-sm max-w-none prose-p:mb-2 prose-p:mt-0 prose-ul:mb-2 prose-li:marker:text-primary-400">
              {@html faq.answer}
            </div>
          </div>
        </div>
      </div>
    {/each}
  </div>
</section>

<style lang="scss">
  .animate-fade-in {
    animation: fadeIn 0.3s ease;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .prose {
    font-size: 1rem;
    line-height: 1.7;
    :global(p),
    :global(ul),
    :global(ol),
    :global(li) {
      margin: 0 0 0.5em 0;
    }
    :global(ul),
    :global(ol) {
      padding-left: 1.2em;
    }
    :global(li) {
      margin-bottom: 0.2em;
    }
  }
</style>

<script lang="ts">
const navLinks = [
  { title: 'Rechner', href: '/' },
  { title: 'FAQ', href: '/faq' },
  { title: 'Impressum', href: '/impressum' },
  { title: 'Datenschutz', href: '/datenschutz' }
];
</script>

<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
  <div class="container mx-auto px-4 flex items-center justify-between h-16">
    <a href="/" class="text-xl font-display font-bold text-primary-700">KFZ-Steuer Rechner</a>
    <ul class="flex space-x-6">
      {#each navLinks as link}
        <li>
          <a href={link.href} class="text-gray-700 hover:text-primary-600 font-medium transition-colors">{link.title}</a>
        </li>
      {/each}
    </ul>
  </div>
</nav>

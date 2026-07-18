<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import AppIcon from '@/components/ui/AppIcon.vue';

const props = defineProps<{ name?: string }>();
const router = useRouter();

const scrolled = ref(false);
const mobileOpen = ref(false);

const links = [
  { label: 'About', hash: '#about' },
  { label: 'Skills', hash: '#skills' },
  { label: 'Work', hash: '#work' },
  { label: 'Experience', hash: '#experience' },
  { label: 'Contact', hash: '#contact' },
];

function onScroll(): void {
  scrolled.value = window.scrollY > 24;
}

async function go(hash: string): Promise<void> {
  mobileOpen.value = false;
  if (router.currentRoute.value.name !== 'home') {
    await router.push({ name: 'home', hash });
  } else {
    document.querySelector(hash)?.scrollIntoView({ behavior: 'smooth' });
  }
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));

const initials = () =>
  (props.name ?? 'Portfolio')
    .split(' ')
    .map((p) => p[0])
    .slice(0, 2)
    .join('')
    .toUpperCase();
</script>

<template>
  <header
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'border-b border-white/10 bg-base-950/80 backdrop-blur-xl' : ''"
  >
    <nav class="container-page flex h-16 items-center justify-between">
      <button
        class="flex items-center gap-2.5 font-semibold text-white"
        @click="go('#top')"
      >
        <span
          class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-accent-500 to-brand-500 text-sm font-bold text-base-950"
        >
          {{ initials() }}
        </span>
        <span class="hidden sm:block">{{ name || 'Portfolio' }}</span>
      </button>

      <div class="hidden items-center gap-1 md:flex">
        <button
          v-for="link in links"
          :key="link.hash"
          class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-300 transition-colors hover:text-white"
          @click="go(link.hash)"
        >
          {{ link.label }}
        </button>
        <button class="btn-primary ml-2" @click="go('#contact')">Let's talk</button>
      </div>

      <button
        class="grid h-10 w-10 place-items-center rounded-lg border border-white/10 text-slate-200 md:hidden"
        aria-label="Toggle menu"
        @click="mobileOpen = !mobileOpen"
      >
        <AppIcon :name="mobileOpen ? 'close' : 'menu'" />
      </button>
    </nav>

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      leave-active-class="transition duration-150 ease-in"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="mobileOpen" class="border-b border-white/10 bg-base-950/95 backdrop-blur-xl md:hidden">
        <div class="container-page flex flex-col py-3">
          <button
            v-for="link in links"
            :key="link.hash"
            class="rounded-lg px-3 py-3 text-left text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white"
            @click="go(link.hash)"
          >
            {{ link.label }}
          </button>
          <button class="btn-primary mt-2" @click="go('#contact')">Let's talk</button>
        </div>
      </div>
    </transition>
  </header>
</template>

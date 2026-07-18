<script setup lang="ts">
import { RouterLink, RouterView, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import AppIcon from '@/components/ui/AppIcon.vue';

const auth = useAuthStore();
const router = useRouter();

const nav = [
  { name: 'admin.dashboard', label: 'Dashboard', icon: 'sparkles' },
  { name: 'admin.projects', label: 'Projects', icon: 'layers' },
  { name: 'admin.skills', label: 'Skills', icon: 'code' },
  { name: 'admin.experiences', label: 'Experience', icon: 'briefcase' },
  { name: 'admin.messages', label: 'Messages', icon: 'mail' },
];

async function logout(): Promise<void> {
  await auth.logout();
  router.push({ name: 'admin.login' });
}
</script>

<template>
  <div class="flex min-h-screen">
    <aside class="hidden w-64 shrink-0 flex-col border-r border-white/10 bg-base-900/60 p-4 md:flex">
      <div class="flex items-center gap-2.5 px-2 py-3">
        <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-accent-500 to-brand-500 text-base-950">
          <AppIcon name="layers" :size="20" />
        </span>
        <span class="font-semibold text-white">Portfolio CMS</span>
      </div>

      <nav class="mt-6 flex-1 space-y-1">
        <RouterLink
          v-for="item in nav"
          :key="item.name"
          :to="{ name: item.name }"
          class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-white/5 hover:text-white"
          active-class="!bg-accent-500/10 !text-accent-300"
        >
          <AppIcon :name="item.icon" :size="18" />
          {{ item.label }}
        </RouterLink>
      </nav>

      <div class="border-t border-white/10 pt-4">
        <a href="/" target="_blank" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-400 hover:text-white">
          <AppIcon name="external" :size="18" />
          View site
        </a>
        <button class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-400 hover:text-white" @click="logout">
          <AppIcon name="logout" :size="18" />
          Sign out
        </button>
      </div>
    </aside>

    <div class="flex-1">
      <header class="sticky top-0 z-20 border-b border-white/10 bg-base-950/80 backdrop-blur-xl md:hidden">
        <div class="flex items-center justify-between px-4 py-3">
          <span class="font-semibold text-white">Portfolio CMS</span>
          <button class="btn-ghost !px-3 !py-1.5" @click="logout">Sign out</button>
        </div>
        <nav class="flex gap-1 overflow-x-auto px-2 pb-2">
          <RouterLink
            v-for="item in nav"
            :key="item.name"
            :to="{ name: item.name }"
            class="whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-medium text-slate-400"
            active-class="!bg-accent-500/10 !text-accent-300"
          >
            {{ item.label }}
          </RouterLink>
        </nav>
      </header>

      <main class="p-5 sm:p-8">
        <RouterView />
      </main>
    </div>
  </div>
</template>

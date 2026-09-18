<script setup lang="ts">
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Profile } from '@/types';

defineProps<{ profile: Profile }>();
const year = new Date().getFullYear();
</script>

<template>
  <footer class="border-t border-white/5 py-10">
    <div class="container-page flex flex-col items-center justify-between gap-4 sm:flex-row">
      <p class="text-sm text-slate-400">
        © {{ year }} {{ profile.name }}. Built with Vue 3 & Vite.
      </p>
      <div class="flex items-center gap-4">
        <a
          v-if="profile.social.github"
          :href="profile.social.github"
          target="_blank"
          rel="noopener"
          class="text-slate-400 transition-colors hover:text-white"
          aria-label="GitHub"
        >
          <AppIcon name="github" :size="20" />
        </a>
        <a
          v-if="profile.social.linkedin"
          :href="profile.social.linkedin"
          target="_blank"
          rel="noopener"
          class="text-slate-400 transition-colors hover:text-white"
          aria-label="LinkedIn"
        >
          <AppIcon name="linkedin" :size="20" />
        </a>
        <a
          v-if="profile.email"
          :href="`mailto:${profile.email}`"
          class="text-slate-400 transition-colors hover:text-white"
          aria-label="Email"
        >
          <AppIcon name="mail" :size="20" />
        </a>
      </div>
    </div>
  </footer>
</template>

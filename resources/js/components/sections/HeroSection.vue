<script setup lang="ts">
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Profile } from '@/types';

defineProps<{ profile: Profile }>();

function scrollTo(hash: string): void {
  document.querySelector(hash)?.scrollIntoView({ behavior: 'smooth' });
}
</script>

<template>
  <section id="top" class="relative overflow-hidden pt-32 pb-20 sm:pt-40 sm:pb-28">
    <div class="container-page grid items-center gap-12 lg:grid-cols-[1.4fr_1fr]">
      <div>
        <img
          v-if="profile.avatar_url"
          v-reveal
          :src="profile.avatar_url"
          :alt="profile.name"
          class="mb-6 h-20 w-20 rounded-2xl object-cover ring-1 ring-white/10"
        />

        <div v-reveal class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs text-slate-300">
          <span class="relative flex h-2 w-2">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75" />
            <span class="relative inline-flex h-2 w-2 rounded-full bg-green-400" />
          </span>
          {{ profile.availability || 'Available for new projects' }}
        </div>

        <h1 v-reveal="80" class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-6xl">
          {{ profile.name }}
          <span class="mt-2 block text-gradient">{{ profile.title }}</span>
        </h1>

        <p v-reveal="160" class="mt-6 max-w-xl text-lg leading-relaxed text-slate-400">
          {{ profile.headline }}
        </p>

        <div v-reveal="240" class="mt-8 flex flex-wrap items-center gap-3">
          <button class="btn-primary" @click="scrollTo('#work')">
            View my work
            <AppIcon name="arrowRight" :size="16" />
          </button>
          <button class="btn-ghost" @click="scrollTo('#contact')">Get in touch</button>
          <a
            v-if="profile.cv_url"
            :href="profile.cv_url"
            target="_blank"
            rel="noopener"
            class="btn-ghost"
          >
            <AppIcon name="download" :size="16" />
            Download CV
          </a>
        </div>

        <div v-reveal="320" class="mt-8 flex items-center gap-4">
          <a
            v-if="profile.social.github"
            :href="profile.social.github"
            target="_blank"
            rel="noopener"
            class="text-slate-400 transition-colors hover:text-white"
            aria-label="GitHub"
          >
            <AppIcon name="github" :size="22" />
          </a>
          <a
            v-if="profile.social.linkedin"
            :href="profile.social.linkedin"
            target="_blank"
            rel="noopener"
            class="text-slate-400 transition-colors hover:text-white"
            aria-label="LinkedIn"
          >
            <AppIcon name="linkedin" :size="22" />
          </a>
          <a
            v-if="profile.email"
            :href="`mailto:${profile.email}`"
            class="text-slate-400 transition-colors hover:text-white"
            aria-label="Email"
          >
            <AppIcon name="mail" :size="22" />
          </a>
        </div>
      </div>

      <div v-reveal="200" class="grid grid-cols-2 gap-4">
        <div
          v-for="stat in profile.stats"
          :key="stat.label"
          class="glass animate-floaty rounded-2xl p-5"
        >
          <p class="text-2xl font-extrabold text-gradient sm:text-3xl">{{ stat.value }}</p>
          <p class="mt-1 text-sm text-slate-400">{{ stat.label }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

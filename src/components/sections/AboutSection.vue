<script setup lang="ts">
import SectionHeading from '@/components/ui/SectionHeading.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Profile } from '@/types';

defineProps<{ profile: Profile }>();

const principles = [
  { icon: 'layers', title: 'Clean architecture', text: 'Layered, service- and repository-driven code with clear boundaries.' },
  { icon: 'sparkles', title: 'SOLID principles', text: 'Maintainable, testable systems that scale with the business.' },
  { icon: 'server', title: 'Robust APIs', text: 'Versioned, well-documented REST APIs powering web and mobile clients.' },
  { icon: 'database', title: 'Data-first design', text: 'Normalized schemas and query optimization for performance at scale.' },
];
</script>

<template>
  <section id="about" class="scroll-mt-20 py-20 sm:py-28">
    <div class="container-page grid gap-12 lg:grid-cols-[1fr_1fr]">
      <div>
        <SectionHeading eyebrow="About" title="Engineering that lasts" />
        <p v-reveal="120" class="mt-6 whitespace-pre-line text-slate-400">{{ profile.bio }}</p>

        <div v-if="profile.location" v-reveal="180" class="mt-6 flex items-center gap-2 text-sm text-slate-400">
          <AppIcon name="location" :size="18" class="text-accent-400" />
          {{ profile.location }}
        </div>
      </div>

      <div class="grid gap-4 sm:grid-cols-2">
        <div
          v-for="(item, i) in principles"
          :key="item.title"
          v-reveal="i * 90"
          class="glass card-hover rounded-2xl p-5"
        >
          <div class="grid h-11 w-11 place-items-center rounded-xl bg-accent-500/10 text-accent-400">
            <AppIcon :name="item.icon" :size="22" />
          </div>
          <h3 class="mt-4 font-semibold text-white">{{ item.title }}</h3>
          <p class="mt-1.5 text-sm text-slate-400">{{ item.text }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

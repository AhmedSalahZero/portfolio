<script setup lang="ts">
import { RouterLink } from 'vue-router';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { ProjectSummary } from '@/types';

defineProps<{ project: ProjectSummary }>();
</script>

<template>
  <RouterLink
    :to="{ name: 'project', params: { slug: project.slug } }"
    class="glass card-hover group relative flex flex-col overflow-hidden rounded-2xl p-6"
  >
    <div class="relative -mx-6 -mt-6 mb-5 h-36 overflow-hidden">
      <img
        v-if="project.cover_image"
        :src="project.cover_image"
        :alt="project.title"
        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
        loading="lazy"
      />
      <div
        v-else
        class="flex h-full w-full items-center justify-center bg-gradient-to-br from-accent-500/20 via-base-800 to-brand-500/20"
      >
        <span class="px-6 text-center text-2xl font-extrabold tracking-tight text-white/15">
          {{ project.title }}
        </span>
      </div>
      <div class="absolute inset-0 bg-gradient-to-t from-base-900/80 to-transparent" />
    </div>

    <div class="flex items-start justify-between gap-3">
      <div>
        <p v-if="project.category" class="text-xs font-medium uppercase tracking-wider text-accent-400">
          {{ project.category }}
        </p>
        <h3 class="mt-1.5 text-lg font-bold text-white group-hover:text-accent-300">
          {{ project.title }}
        </h3>
      </div>
      <span
        v-if="project.is_featured"
        class="shrink-0 rounded-full border border-brand-500/30 bg-brand-500/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-brand-400"
      >
        Featured
      </span>
    </div>

    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-400">
      {{ project.tagline }}
    </p>

    <div v-if="project.metrics.length" class="mt-5 grid grid-cols-2 gap-3">
      <div
        v-for="metric in project.metrics.slice(0, 2)"
        :key="metric.label"
        class="rounded-xl border border-white/5 bg-base-900/60 px-3 py-2"
      >
        <p class="text-sm font-bold text-white">{{ metric.value }}</p>
        <p class="text-[11px] text-slate-400">{{ metric.label }}</p>
      </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-1.5">
      <span
        v-for="skill in project.skills.slice(0, 4)"
        :key="skill.id"
        class="chip text-[11px]"
      >
        {{ skill.name }}
      </span>
      <span v-if="project.skills.length > 4" class="chip text-[11px] text-slate-400">
        +{{ project.skills.length - 4 }}
      </span>
    </div>

    <div class="mt-6 flex items-center gap-1.5 text-sm font-medium text-accent-400">
      <span>View case study</span>
      <AppIcon
        name="arrowRight"
        :size="16"
        class="transition-transform group-hover:translate-x-1"
      />
    </div>
  </RouterLink>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import SectionHeading from '@/components/ui/SectionHeading.vue';
import ProjectCard from '@/components/ui/ProjectCard.vue';
import type { ProjectSummary } from '@/types';

const props = defineProps<{ projects: ProjectSummary[] }>();

const activeFilter = ref<string>('All');

const filters = computed<string[]>(() => {
  const set = new Set<string>();
  props.projects.forEach((p) => p.skills.forEach((s) => set.add(s.name)));
  // Keep the most common technologies as quick filters.
  const counts = new Map<string, number>();
  props.projects.forEach((p) => p.skills.forEach((s) => counts.set(s.name, (counts.get(s.name) ?? 0) + 1)));
  const top = Array.from(set).sort((a, b) => (counts.get(b) ?? 0) - (counts.get(a) ?? 0)).slice(0, 7);
  return ['All', ...top];
});

const filtered = computed(() => {
  if (activeFilter.value === 'All') return props.projects;
  return props.projects.filter((p) => p.skills.some((s) => s.name === activeFilter.value));
});
</script>

<template>
  <section id="work" class="scroll-mt-20 border-t border-white/5 py-20 sm:py-28">
    <div class="container-page">
      <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <SectionHeading
          eyebrow="Selected work"
          title="Case studies"
          subtitle="Production platforms across mobility, marketplaces, EdTech, ERP, and enterprise domains."
        />
      </div>

      <div v-reveal="120" class="mt-8 flex flex-wrap gap-2">
        <button
          v-for="filter in filters"
          :key="filter"
          class="chip transition-all"
          :class="activeFilter === filter
            ? 'border-accent-500/50 bg-accent-500/10 text-accent-300'
            : 'hover:border-white/25'"
          @click="activeFilter = filter"
        >
          {{ filter }}
        </button>
      </div>

      <transition-group
        tag="div"
        class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 translate-y-3"
      >
        <ProjectCard v-for="project in filtered" :key="project.id" :project="project" />
      </transition-group>

      <p v-if="!filtered.length" class="mt-10 text-center text-slate-500">
        No projects match this filter yet.
      </p>
    </div>
  </section>
</template>

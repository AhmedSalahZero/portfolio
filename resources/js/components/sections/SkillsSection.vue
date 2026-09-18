<script setup lang="ts">
import { computed } from 'vue';
import SectionHeading from '@/components/ui/SectionHeading.vue';
import type { Skill } from '@/types';

const props = defineProps<{ skills: Skill[] }>();

const grouped = computed(() => {
  const map = new Map<string, { label: string; items: Skill[] }>();
  for (const skill of props.skills) {
    if (!map.has(skill.category)) {
      map.set(skill.category, { label: skill.category_label, items: [] });
    }
    map.get(skill.category)!.items.push(skill);
  }
  return Array.from(map.values());
});
</script>

<template>
  <section id="skills" class="scroll-mt-20 border-t border-white/5 py-20 sm:py-28">
    <div class="container-page">
      <SectionHeading
        eyebrow="Skills"
        title="Tools I use to ship"
        subtitle="A pragmatic, full-stack toolkit centered on the Laravel and Vue ecosystem."
      />

      <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="(group, gi) in grouped"
          :key="group.label"
          v-reveal="gi * 80"
          class="glass rounded-2xl p-6"
        >
          <h3 class="text-sm font-semibold uppercase tracking-wider text-accent-400">
            {{ group.label }}
          </h3>
          <ul class="mt-5 space-y-4">
            <li v-for="skill in group.items" :key="skill.id">
              <div class="flex items-center justify-between text-sm">
                <span class="font-medium text-slate-200">{{ skill.name }}</span>
                <span class="text-xs text-slate-400">{{ skill.level }}%</span>
              </div>
              <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-white/5">
                <div
                  class="h-full rounded-full bg-gradient-to-r from-accent-500 to-brand-500"
                  :style="{ width: `${skill.level}%` }"
                />
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

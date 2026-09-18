<script setup lang="ts">
import SectionHeading from '@/components/ui/SectionHeading.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Experience } from '@/types';

const props = defineProps<{ experiences: Experience[] }>();

function period(exp: Experience): string {
  const fmt = (d: string | null) =>
    d ? new Date(d).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : '';
  const start = fmt(exp.start_date);
  const end = exp.is_current ? 'Present' : fmt(exp.end_date);
  return `${start} — ${end}`;
}
</script>

<template>
  <section v-if="props.experiences.length" id="experience" class="scroll-mt-20 border-t border-white/5 py-20 sm:py-28">
    <div class="container-page">
      <SectionHeading eyebrow="Experience" title="Where I've made an impact" />

      <div class="mt-12 space-y-6">
        <div
          v-for="(exp, i) in props.experiences"
          :key="exp.id"
          v-reveal="i * 90"
          class="glass relative rounded-2xl p-6 pl-8"
        >
          <span class="absolute left-0 top-6 h-8 w-1 rounded-r-full bg-gradient-to-b from-accent-500 to-brand-500" />
          <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <h3 class="flex items-center gap-2 text-lg font-bold text-white">
                <AppIcon name="briefcase" :size="18" class="text-accent-400" />
                {{ exp.role }}
              </h3>
              <p class="mt-0.5 text-sm text-accent-300">
                {{ exp.company }}<span v-if="exp.location" class="text-slate-400"> · {{ exp.location }}</span>
              </p>
            </div>
            <span class="chip shrink-0 text-[11px]">{{ period(exp) }}</span>
          </div>

          <p v-if="exp.description" class="mt-4 text-sm text-slate-400">{{ exp.description }}</p>

          <ul v-if="exp.achievements.length" class="mt-4 space-y-2">
            <li
              v-for="(item, j) in exp.achievements"
              :key="j"
              class="flex items-start gap-2 text-sm text-slate-300"
            >
              <AppIcon name="check" :size="16" class="mt-0.5 shrink-0 text-accent-400" />
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

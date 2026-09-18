<script setup lang="ts">
import SectionHeading from '@/components/ui/SectionHeading.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Testimonial } from '@/types';

const props = defineProps<{ testimonials: Testimonial[] }>();
</script>

<template>
  <section v-if="props.testimonials.length" class="border-t border-white/5 py-20 sm:py-28">
    <div class="container-page">
      <SectionHeading eyebrow="Testimonials" title="What people say" />

      <div class="mt-12 grid gap-6 md:grid-cols-2">
        <figure
          v-for="(item, i) in props.testimonials"
          :key="item.id"
          v-reveal="i * 90"
          class="glass rounded-2xl p-7"
        >
          <AppIcon name="quote" :size="28" class="text-accent-500/40" />
          <blockquote class="mt-4 text-slate-300">"{{ item.quote }}"</blockquote>
          <figcaption class="mt-6 flex items-center gap-3">
            <span
              class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-accent-500 to-brand-500 text-sm font-bold text-base-950"
            >
              {{ item.author.charAt(0) }}
            </span>
            <div>
              <p class="text-sm font-semibold text-white">{{ item.author }}</p>
              <p class="text-xs text-slate-400">
                {{ [item.position, item.company].filter(Boolean).join(' · ') }}
              </p>
            </div>
          </figcaption>
        </figure>
      </div>
    </div>
  </section>
</template>

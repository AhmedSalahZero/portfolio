<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { useSiteStore } from '@/stores/site';
import AppIcon from '@/components/ui/AppIcon.vue';
import LoadingScreen from '@/components/ui/LoadingScreen.vue';
import type { Project } from '@/types';

const props = defineProps<{ slug: string }>();
const router = useRouter();
const siteStore = useSiteStore();

const project = ref<Project | null>(null);
const loading = ref(true);
const notFound = ref(false);

function load(slug: string): void {
    loading.value = true;
    notFound.value = false;
    const found = siteStore.projectBySlug(slug);
    if (!found) {
        project.value = null;
        notFound.value = true;
        loading.value = false;
        return;
    }

    project.value = found;
    const base = import.meta.env.VITE_APP_NAME || 'Portfolio';
    document.title = `${found.title} · ${base}`;
    loading.value = false;
}

onMounted(() => {
    siteStore.load();
    load(props.slug);
});
watch(() => props.slug, (slug) => load(slug));

const sections = [
    { key: 'problem', label: 'The challenge' },
    { key: 'solution', label: 'The solution' },
    { key: 'outcome', label: 'The outcome' },
] as const;
</script>

<template>
  <LoadingScreen v-if="loading" message="Loading case study…" />

  <div v-else-if="notFound" class="grid min-h-screen place-items-center px-6 text-center">
    <div>
      <p class="text-2xl font-bold text-white">Case study not found</p>
      <button class="btn-primary mt-6" @click="router.push('/')">Back home</button>
    </div>
  </div>

  <article v-else-if="project" class="pb-24">
    <div class="border-b border-white/5">
      <div class="container-page pt-28 pb-14">
        <RouterLink
          to="/#work"
          class="inline-flex items-center gap-1.5 text-sm text-slate-400 transition-colors hover:text-white"
        >
          <AppIcon name="arrowLeft" :size="16" />
          All projects
        </RouterLink>

        <div class="mt-6 flex flex-wrap items-center gap-3">
          <span v-if="project.category" class="chip text-accent-300">{{ project.category }}</span>
          <span v-if="project.year" class="chip">{{ project.year }}</span>
          <span v-if="project.role" class="chip">{{ project.role }}</span>
        </div>

        <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
          {{ project.title }}
        </h1>
        <p class="mt-4 max-w-2xl text-lg text-slate-400">{{ project.tagline }}</p>

        <div class="mt-7 flex flex-wrap gap-3">
          <a v-if="project.live_url" :href="project.live_url" target="_blank" rel="noopener" class="btn-primary">
            Visit live site
            <AppIcon name="external" :size="16" />
          </a>
          <a v-if="project.repo_url" :href="project.repo_url" target="_blank" rel="noopener" class="btn-ghost">
            <AppIcon name="github" :size="16" />
            Source
          </a>
        </div>
      </div>
    </div>

    <div class="container-page grid gap-12 pt-14 lg:grid-cols-[1fr_320px]">
      <div class="space-y-10">
        <section>
          <h2 class="text-xl font-bold text-white">Overview</h2>
          <p class="mt-3 text-slate-400">{{ project.summary }}</p>
        </section>

        <section v-for="s in sections" :key="s.key" v-show="project[s.key]">
          <h2 class="text-xl font-bold text-white">{{ s.label }}</h2>
          <p class="mt-3 whitespace-pre-line text-slate-400">{{ project[s.key] }}</p>
        </section>

        <section v-if="project.highlights.length">
          <h2 class="text-xl font-bold text-white">Key highlights</h2>
          <ul class="mt-4 space-y-3">
            <li
              v-for="(item, i) in project.highlights"
              :key="i"
              class="glass flex items-start gap-3 rounded-xl p-4"
            >
              <AppIcon name="check" :size="18" class="mt-0.5 shrink-0 text-accent-400" />
              <span class="text-sm text-slate-300">{{ item }}</span>
            </li>
          </ul>
        </section>

        <section v-if="project.images.length" class="grid gap-4 sm:grid-cols-2">
          <figure v-for="img in project.images" :key="img.id" class="glass overflow-hidden rounded-xl">
            <img :src="img.url" :alt="img.caption || project.title" class="h-full w-full object-cover" loading="lazy" />
            <figcaption v-if="img.caption" class="p-3 text-xs text-slate-400">{{ img.caption }}</figcaption>
          </figure>
        </section>
      </div>

      <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
        <div v-if="project.metrics.length" class="glass rounded-2xl p-6">
          <h3 class="text-sm font-semibold uppercase tracking-wider text-accent-400">Impact</h3>
          <dl class="mt-4 grid grid-cols-2 gap-4">
            <div v-for="m in project.metrics" :key="m.label">
              <dt class="text-xs text-slate-400">{{ m.label }}</dt>
              <dd class="text-lg font-bold text-white">{{ m.value }}</dd>
            </div>
          </dl>
        </div>

        <div class="glass rounded-2xl p-6">
          <h3 class="text-sm font-semibold uppercase tracking-wider text-accent-400">Tech stack</h3>
          <div class="mt-4 flex flex-wrap gap-2">
            <span v-for="skill in project.skills" :key="skill.id" class="chip">{{ skill.name }}</span>
          </div>
        </div>

        <div v-if="project.client" class="glass rounded-2xl p-6">
          <h3 class="text-sm font-semibold uppercase tracking-wider text-accent-400">Client</h3>
          <p class="mt-2 text-slate-300">{{ project.client }}</p>
        </div>
      </aside>
    </div>
  </article>
</template>

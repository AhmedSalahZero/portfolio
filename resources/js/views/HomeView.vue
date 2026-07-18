<script setup lang="ts">
import { onMounted, nextTick } from 'vue';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useSiteStore } from '@/stores/site';
import NavBar from '@/components/sections/NavBar.vue';
import HeroSection from '@/components/sections/HeroSection.vue';
import AboutSection from '@/components/sections/AboutSection.vue';
import SkillsSection from '@/components/sections/SkillsSection.vue';
import ProjectsSection from '@/components/sections/ProjectsSection.vue';
import ExperienceSection from '@/components/sections/ExperienceSection.vue';
import TestimonialsSection from '@/components/sections/TestimonialsSection.vue';
import ContactSection from '@/components/sections/ContactSection.vue';
import SiteFooter from '@/components/sections/SiteFooter.vue';
import LoadingScreen from '@/components/ui/LoadingScreen.vue';

const store = useSiteStore();
const { data, loading, error } = storeToRefs(store);
const route = useRoute();

onMounted(async () => {
  await store.load();
  if (route.hash) {
    await nextTick();
    document.querySelector(route.hash)?.scrollIntoView({ behavior: 'smooth' });
  }
});
</script>

<template>
  <LoadingScreen v-if="loading && !data" />

  <div v-else-if="error && !data" class="grid min-h-screen place-items-center px-6 text-center">
    <div>
      <p class="text-lg text-slate-300">{{ error }}</p>
      <button class="btn-primary mt-4" @click="store.load(true)">Retry</button>
    </div>
  </div>

  <div v-else-if="data">
    <NavBar :name="data.profile.name" />
    <main>
      <HeroSection :profile="data.profile" />
      <AboutSection :profile="data.profile" />
      <SkillsSection :skills="data.skills" />
      <ProjectsSection :projects="data.projects" />
      <ExperienceSection :experiences="data.experiences" />
      <TestimonialsSection :testimonials="data.testimonials" />
      <ContactSection :profile="data.profile" />
    </main>
    <SiteFooter :profile="data.profile" />
  </div>
</template>

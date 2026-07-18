<script setup lang="ts">
defineProps<{
  eyebrow?: string;
  title: string;
  subtitle?: string;
}>();
</script>

<template>
  <div class="max-w-2xl">
    <p v-if="eyebrow" v-reveal class="eyebrow">{{ eyebrow }}</p>
    <h2 v-reveal="60" class="section-title mt-3">{{ title }}</h2>
    <p v-if="subtitle" v-reveal="120" class="mt-4 text-slate-400">{{ subtitle }}</p>
  </div>
</template>

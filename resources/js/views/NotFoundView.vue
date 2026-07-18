<script setup lang="ts">
import { useRouter } from 'vue-router';
const router = useRouter();
</script>

<template>
  <div class="grid min-h-screen place-items-center px-6 text-center">
    <div>
      <p class="text-7xl font-extrabold text-gradient">404</p>
      <p class="mt-4 text-lg text-slate-400">This page could not be found.</p>
      <button class="btn-primary mt-6" @click="router.push('/')">Back home</button>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ message?: string }>();
</script>

<template>
  <div class="grid min-h-screen place-items-center">
    <div class="flex flex-col items-center gap-4">
      <span class="h-10 w-10 animate-spin rounded-full border-2 border-white/10 border-t-accent-500" />
      <p class="text-sm text-slate-500">{{ message || 'Loading…' }}</p>
    </div>
  </div>
</template>

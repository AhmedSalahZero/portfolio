<script setup lang="ts">
defineProps<{
  label: string;
  active?: boolean;
}>();
</script>

<template>
  <span
    class="chip transition-colors"
    :class="active ? 'border-accent-500/50 bg-accent-500/10 text-accent-300' : ''"
  >
    {{ label }}
  </span>
</template>

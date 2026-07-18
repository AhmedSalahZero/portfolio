<script setup lang="ts">
import AppIcon from '@/components/ui/AppIcon.vue';

defineProps<{ title: string; open: boolean }>();
const emit = defineEmits<{ close: [] }>();
</script>

<template>
  <transition
    enter-active-class="transition duration-200"
    enter-from-class="opacity-0"
    leave-active-class="transition duration-150"
    leave-to-class="opacity-0"
  >
    <div v-if="open" class="fixed inset-0 z-50 grid place-items-center overflow-y-auto bg-black/60 p-4 backdrop-blur-sm" @click.self="emit('close')">
      <div class="glass my-8 w-full max-w-2xl rounded-2xl bg-base-900/95 p-6 shadow-2xl">
        <div class="mb-5 flex items-center justify-between">
          <h2 class="text-lg font-bold text-white">{{ title }}</h2>
          <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-white/5 hover:text-white" @click="emit('close')">
            <AppIcon name="close" :size="18" />
          </button>
        </div>
        <slot />
      </div>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';
import { adminApi } from '@/services/adminApi';
import AdminHeader from '@/admin/components/AdminHeader.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import { useAuthStore } from '@/stores/auth';

const auth = useAuthStore();
const stats = ref<Record<string, number> | null>(null);
const loading = ref(true);

const cards = [
  { key: 'published_projects', label: 'Published projects', icon: 'layers', to: 'admin.projects' },
  { key: 'skills', label: 'Skills', icon: 'code', to: 'admin.skills' },
  { key: 'experiences', label: 'Experiences', icon: 'briefcase', to: 'admin.experiences' },
  { key: 'unread_messages', label: 'Unread messages', icon: 'mail', to: 'admin.messages' },
];

onMounted(async () => {
  try {
    stats.value = { ...(await adminApi.dashboard()) } as Record<string, number>;
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div>
    <AdminHeader :title="`Welcome back, ${auth.user?.name ?? 'Admin'}`" subtitle="Here's an overview of your portfolio content." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
      <RouterLink
        v-for="card in cards"
        :key="card.key"
        :to="{ name: card.to }"
        class="glass card-hover rounded-2xl p-5"
      >
        <div class="flex items-center justify-between">
          <span class="grid h-10 w-10 place-items-center rounded-xl bg-accent-500/10 text-accent-400">
            <AppIcon :name="card.icon" :size="20" />
          </span>
          <span class="text-3xl font-extrabold text-white">
            {{ loading ? '—' : (stats?.[card.key] ?? 0) }}
          </span>
        </div>
        <p class="mt-4 text-sm text-slate-400">{{ card.label }}</p>
      </RouterLink>
    </div>
  </div>
</template>

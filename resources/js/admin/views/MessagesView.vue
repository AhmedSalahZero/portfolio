<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { adminApi } from '@/services/adminApi';
import AdminHeader from '@/admin/components/AdminHeader.vue';
import AdminModal from '@/admin/components/AdminModal.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { ContactMessage } from '@/types';

const messages = ref<ContactMessage[]>([]);
const loading = ref(true);
const selected = ref<ContactMessage | null>(null);

async function load(): Promise<void> {
  loading.value = true;
  try {
    messages.value = await adminApi.messages();
  } finally {
    loading.value = false;
  }
}

async function open(message: ContactMessage): Promise<void> {
  selected.value = await adminApi.message(message.id);
  const idx = messages.value.findIndex((m) => m.id === message.id);
  if (idx !== -1) messages.value[idx].is_read = true;
}

async function remove(message: ContactMessage): Promise<void> {
  if (!confirm('Delete this message?')) return;
  await adminApi.deleteMessage(message.id);
  if (selected.value?.id === message.id) selected.value = null;
  await load();
}

function formatDate(iso: string | null): string {
  return iso ? new Date(iso).toLocaleString() : '';
}

onMounted(load);
</script>

<template>
  <div>
    <AdminHeader title="Messages" subtitle="Inbound messages from your contact form." />

    <p v-if="loading" class="text-slate-500">Loading…</p>
    <p v-else-if="!messages.length" class="glass rounded-2xl p-8 text-center text-slate-500">
      No messages yet.
    </p>

    <div v-else class="space-y-3">
      <button
        v-for="message in messages"
        :key="message.id"
        class="glass card-hover flex w-full items-start justify-between rounded-xl p-5 text-left"
        @click="open(message)"
      >
        <div class="min-w-0">
          <div class="flex items-center gap-2">
            <span v-if="!message.is_read" class="h-2 w-2 shrink-0 rounded-full bg-accent-400" />
            <p class="truncate font-semibold text-white">{{ message.subject || '(No subject)' }}</p>
          </div>
          <p class="mt-1 text-sm text-slate-400">{{ message.name }} · {{ message.email }}</p>
          <p class="mt-1 truncate text-sm text-slate-500">{{ message.message }}</p>
        </div>
        <div class="ml-4 flex shrink-0 flex-col items-end gap-2">
          <span class="text-xs text-slate-600">{{ formatDate(message.created_at) }}</span>
          <span
            class="grid h-8 w-8 place-items-center rounded-lg text-slate-500 hover:bg-red-500/10 hover:text-red-400"
            @click.stop="remove(message)"
          >
            <AppIcon name="trash" :size="16" />
          </span>
        </div>
      </button>
    </div>

    <AdminModal :open="!!selected" :title="selected?.subject || 'Message'" @close="selected = null">
      <div v-if="selected" class="space-y-4">
        <div class="flex flex-wrap gap-4 text-sm">
          <div>
            <p class="text-xs text-slate-500">From</p>
            <p class="text-slate-200">{{ selected.name }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500">Email</p>
            <a :href="`mailto:${selected.email}`" class="text-accent-400 hover:underline">{{ selected.email }}</a>
          </div>
          <div>
            <p class="text-xs text-slate-500">Received</p>
            <p class="text-slate-200">{{ formatDate(selected.created_at) }}</p>
          </div>
        </div>
        <div class="rounded-xl border border-white/10 bg-base-850 p-4">
          <p class="whitespace-pre-line text-slate-300">{{ selected.message }}</p>
        </div>
        <div class="flex justify-end gap-2">
          <a :href="`mailto:${selected.email}`" class="btn-primary">Reply by email</a>
        </div>
      </div>
    </AdminModal>
  </div>
</template>

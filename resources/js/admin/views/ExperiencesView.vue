<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import { adminApi } from '@/services/adminApi';
import { extractMessage, extractValidationErrors } from '@/services/api';
import AdminHeader from '@/admin/components/AdminHeader.vue';
import AdminModal from '@/admin/components/AdminModal.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Experience } from '@/types';

const items = ref<Experience[]>([]);
const loading = ref(true);
const modalOpen = ref(false);
const saving = ref(false);
const editing = ref<Experience | null>(null);
const errors = ref<Record<string, string>>({});
const formError = ref('');

const form = reactive({
  company: '', role: '', location: '', employment_type: '',
  start_date: '', end_date: '', is_current: false, description: '',
  achievements: '', sort_order: 0,
});

function reset(): void {
  Object.assign(form, {
    company: '', role: '', location: '', employment_type: '',
    start_date: '', end_date: '', is_current: false, description: '', achievements: '', sort_order: 0,
  });
  errors.value = {};
  formError.value = '';
}

async function load(): Promise<void> {
  loading.value = true;
  try {
    items.value = await adminApi.experiences();
  } finally {
    loading.value = false;
  }
}

function openCreate(): void {
  editing.value = null;
  reset();
  modalOpen.value = true;
}
function openEdit(exp: Experience): void {
  editing.value = exp;
  reset();
  Object.assign(form, {
    company: exp.company, role: exp.role, location: exp.location ?? '',
    employment_type: exp.employment_type ?? '', start_date: exp.start_date ?? '',
    end_date: exp.end_date ?? '', is_current: exp.is_current, description: exp.description ?? '',
    achievements: (exp.achievements ?? []).join('\n'), sort_order: exp.sort_order,
  });
  modalOpen.value = true;
}

async function save(): Promise<void> {
  saving.value = true;
  errors.value = {};
  formError.value = '';
  const payload = {
    ...form,
    end_date: form.is_current ? null : (form.end_date || null),
    achievements: form.achievements.split('\n').map((a) => a.trim()).filter(Boolean),
  };
  try {
    if (editing.value) await adminApi.updateExperience(editing.value.id, payload as never);
    else await adminApi.createExperience(payload as never);
    modalOpen.value = false;
    await load();
  } catch (e) {
    errors.value = extractValidationErrors(e);
    formError.value = Object.keys(errors.value).length ? 'Please fix the highlighted fields.' : extractMessage(e);
  } finally {
    saving.value = false;
  }
}

async function remove(exp: Experience): Promise<void> {
  if (!confirm(`Delete "${exp.role} @ ${exp.company}"?`)) return;
  await adminApi.deleteExperience(exp.id);
  await load();
}

onMounted(load);
</script>

<template>
  <div>
    <AdminHeader title="Experience" subtitle="Your professional timeline.">
      <template #actions>
        <button class="btn-primary" @click="openCreate"><AppIcon name="plus" :size="16" /> New entry</button>
      </template>
    </AdminHeader>

    <p v-if="loading" class="text-slate-500">Loading…</p>

    <div v-else class="space-y-3">
      <div v-for="exp in items" :key="exp.id" class="glass flex items-start justify-between rounded-xl p-5">
        <div>
          <p class="font-semibold text-white">{{ exp.role }}</p>
          <p class="text-sm text-accent-300">{{ exp.company }}</p>
          <p class="mt-1 text-xs text-slate-500">
            {{ exp.start_date }} — {{ exp.is_current ? 'Present' : exp.end_date }}
          </p>
        </div>
        <div class="flex gap-1">
          <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-white/5 hover:text-white" @click="openEdit(exp)">
            <AppIcon name="edit" :size="16" />
          </button>
          <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-400" @click="remove(exp)">
            <AppIcon name="trash" :size="16" />
          </button>
        </div>
      </div>
    </div>

    <AdminModal :open="modalOpen" :title="editing ? 'Edit experience' : 'New experience'" @close="modalOpen = false">
      <form class="space-y-4" @submit.prevent="save">
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Company</span>
            <input v-model="form.company" class="field" type="text" />
            <span v-if="errors.company" class="mt-1 block text-xs text-red-400">{{ errors.company }}</span>
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Role</span>
            <input v-model="form.role" class="field" type="text" />
            <span v-if="errors.role" class="mt-1 block text-xs text-red-400">{{ errors.role }}</span>
          </label>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Location</span>
            <input v-model="form.location" class="field" type="text" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Employment type</span>
            <input v-model="form.employment_type" class="field" type="text" placeholder="Full-time" />
          </label>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Start date</span>
            <input v-model="form.start_date" class="field" type="date" />
            <span v-if="errors.start_date" class="mt-1 block text-xs text-red-400">{{ errors.start_date }}</span>
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">End date</span>
            <input v-model="form.end_date" class="field" type="date" :disabled="form.is_current" />
          </label>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-300">
          <input v-model="form.is_current" type="checkbox" class="h-4 w-4 rounded border-white/20 bg-base-850" /> Current role
        </label>
        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Description</span>
          <textarea v-model="form.description" class="field" rows="2" />
        </label>
        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Achievements (one per line)</span>
          <textarea v-model="form.achievements" class="field" rows="3" />
        </label>
        <p v-if="formError" class="text-sm text-red-400">{{ formError }}</p>
        <div class="flex justify-end gap-2 border-t border-white/10 pt-4">
          <button type="button" class="btn-ghost" @click="modalOpen = false">Cancel</button>
          <button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button>
        </div>
      </form>
    </AdminModal>
  </div>
</template>

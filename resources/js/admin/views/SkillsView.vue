<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import { adminApi } from '@/services/adminApi';
import { extractMessage, extractValidationErrors } from '@/services/api';
import AdminHeader from '@/admin/components/AdminHeader.vue';
import AdminModal from '@/admin/components/AdminModal.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Skill } from '@/types';

const categories = [
  { value: 'backend', label: 'Backend' },
  { value: 'frontend', label: 'Frontend' },
  { value: 'database', label: 'Databases' },
  { value: 'devops', label: 'DevOps & Cloud' },
  { value: 'tools', label: 'Tools & Practices' },
];

const skills = ref<Skill[]>([]);
const loading = ref(true);
const modalOpen = ref(false);
const saving = ref(false);
const editing = ref<Skill | null>(null);
const errors = ref<Record<string, string>>({});
const formError = ref('');

const form = reactive({ name: '', category: 'backend', level: 80, icon: '', is_featured: false, sort_order: 0 });

function reset(): void {
  Object.assign(form, { name: '', category: 'backend', level: 80, icon: '', is_featured: false, sort_order: 0 });
  errors.value = {};
  formError.value = '';
}

async function load(): Promise<void> {
  loading.value = true;
  try {
    skills.value = await adminApi.skills();
  } finally {
    loading.value = false;
  }
}

function openCreate(): void {
  editing.value = null;
  reset();
  modalOpen.value = true;
}
function openEdit(skill: Skill): void {
  editing.value = skill;
  reset();
  Object.assign(form, {
    name: skill.name, category: skill.category, level: skill.level,
    icon: skill.icon ?? '', is_featured: skill.is_featured, sort_order: skill.sort_order,
  });
  modalOpen.value = true;
}

async function save(): Promise<void> {
  saving.value = true;
  errors.value = {};
  formError.value = '';
  try {
    if (editing.value) await adminApi.updateSkill(editing.value.id, form);
    else await adminApi.createSkill(form);
    modalOpen.value = false;
    await load();
  } catch (e) {
    errors.value = extractValidationErrors(e);
    formError.value = Object.keys(errors.value).length ? '' : extractMessage(e);
  } finally {
    saving.value = false;
  }
}

async function remove(skill: Skill): Promise<void> {
  if (!confirm(`Delete "${skill.name}"?`)) return;
  await adminApi.deleteSkill(skill.id);
  await load();
}

onMounted(load);
</script>

<template>
  <div>
    <AdminHeader title="Skills" subtitle="Group and rank the technologies you work with.">
      <template #actions>
        <button class="btn-primary" @click="openCreate"><AppIcon name="plus" :size="16" /> New skill</button>
      </template>
    </AdminHeader>

    <p v-if="loading" class="text-slate-500">Loading…</p>

    <div v-else class="glass overflow-hidden rounded-2xl">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-slate-500">
          <tr>
            <th class="px-5 py-3">Name</th>
            <th class="px-5 py-3">Category</th>
            <th class="hidden px-5 py-3 sm:table-cell">Level</th>
            <th class="px-5 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
          <tr v-for="skill in skills" :key="skill.id" class="hover:bg-white/[0.02]">
            <td class="px-5 py-3 font-medium text-white">
              {{ skill.name }}
              <span v-if="skill.is_featured" class="chip ml-1 text-[10px] text-brand-400">Featured</span>
            </td>
            <td class="px-5 py-3 text-slate-400">{{ skill.category_label }}</td>
            <td class="hidden px-5 py-3 sm:table-cell">
              <div class="flex items-center gap-2">
                <div class="h-1.5 w-24 overflow-hidden rounded-full bg-white/5">
                  <div class="h-full bg-accent-500" :style="{ width: `${skill.level}%` }" />
                </div>
                <span class="text-xs text-slate-500">{{ skill.level }}%</span>
              </div>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-1">
                <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-white/5 hover:text-white" @click="openEdit(skill)">
                  <AppIcon name="edit" :size="16" />
                </button>
                <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-400" @click="remove(skill)">
                  <AppIcon name="trash" :size="16" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AdminModal :open="modalOpen" :title="editing ? 'Edit skill' : 'New skill'" @close="modalOpen = false">
      <form class="space-y-4" @submit.prevent="save">
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Name</span>
            <input v-model="form.name" class="field" type="text" />
            <span v-if="errors.name" class="mt-1 block text-xs text-red-400">{{ errors.name }}</span>
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Category</span>
            <select v-model="form.category" class="field">
              <option v-for="c in categories" :key="c.value" :value="c.value">{{ c.label }}</option>
            </select>
          </label>
        </div>
        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Level ({{ form.level }}%)</span>
          <input v-model.number="form.level" type="range" min="1" max="100" class="w-full accent-sky-500" />
        </label>
        <div class="flex flex-wrap items-center gap-6">
          <label class="flex items-center gap-2 text-sm text-slate-300">
            <input v-model="form.is_featured" type="checkbox" class="h-4 w-4 rounded border-white/20 bg-base-850" /> Featured
          </label>
          <label class="flex items-center gap-2 text-sm text-slate-300">
            Sort <input v-model.number="form.sort_order" type="number" class="field w-20 !py-1.5" />
          </label>
        </div>
        <p v-if="formError" class="text-sm text-red-400">{{ formError }}</p>
        <div class="flex justify-end gap-2 border-t border-white/10 pt-4">
          <button type="button" class="btn-ghost" @click="modalOpen = false">Cancel</button>
          <button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button>
        </div>
      </form>
    </AdminModal>
  </div>
</template>

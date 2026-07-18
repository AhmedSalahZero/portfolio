<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import { adminApi } from '@/services/adminApi';
import { extractMessage, extractValidationErrors } from '@/services/api';
import AdminHeader from '@/admin/components/AdminHeader.vue';
import AdminModal from '@/admin/components/AdminModal.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Project, Skill } from '@/types';

const projects = ref<Project[]>([]);
const skills = ref<Skill[]>([]);
const loading = ref(true);
const modalOpen = ref(false);
const saving = ref(false);
const editing = ref<Project | null>(null);
const errors = ref<Record<string, string>>({});
const formError = ref('');

interface FormState {
  title: string;
  tagline: string;
  category: string;
  role: string;
  client: string;
  year: number | null;
  summary: string;
  problem: string;
  solution: string;
  outcome: string;
  cover_image: string;
  live_url: string;
  repo_url: string;
  is_featured: boolean;
  is_published: boolean;
  sort_order: number;
  highlights: string;
  metrics: { label: string; value: string }[];
  skill_ids: number[];
}

const form = reactive<FormState>(blankForm());

function blankForm(): FormState {
  return {
    title: '', tagline: '', category: '', role: '', client: '', year: new Date().getFullYear(),
    summary: '', problem: '', solution: '', outcome: '', cover_image: '', live_url: '', repo_url: '',
    is_featured: false, is_published: true, sort_order: 0, highlights: '', metrics: [], skill_ids: [],
  };
}

async function loadAll(): Promise<void> {
  loading.value = true;
  try {
    [projects.value, skills.value] = await Promise.all([adminApi.projects(), adminApi.skills()]);
  } finally {
    loading.value = false;
  }
}

function openCreate(): void {
  editing.value = null;
  Object.assign(form, blankForm());
  errors.value = {};
  formError.value = '';
  modalOpen.value = true;
}

function openEdit(project: Project): void {
  editing.value = project;
  errors.value = {};
  formError.value = '';
  Object.assign(form, {
    title: project.title, tagline: project.tagline, category: project.category ?? '',
    role: project.role ?? '', client: project.client ?? '', year: project.year,
    summary: project.summary, problem: project.problem ?? '', solution: project.solution ?? '',
    outcome: project.outcome ?? '', cover_image: project.cover_image ?? '', live_url: project.live_url ?? '',
    repo_url: project.repo_url ?? '', is_featured: project.is_featured, is_published: project.is_published,
    sort_order: project.sort_order, highlights: (project.highlights ?? []).join('\n'),
    metrics: (project.metrics ?? []).map((m) => ({ ...m })), skill_ids: project.skills.map((s) => s.id),
  });
  modalOpen.value = true;
}

function addMetric(): void {
  form.metrics.push({ label: '', value: '' });
}
function removeMetric(i: number): void {
  form.metrics.splice(i, 1);
}
function toggleSkill(id: number): void {
  const idx = form.skill_ids.indexOf(id);
  if (idx === -1) form.skill_ids.push(id);
  else form.skill_ids.splice(idx, 1);
}

async function save(): Promise<void> {
  saving.value = true;
  errors.value = {};
  formError.value = '';
  const payload = {
    ...form,
    year: form.year || null,
    highlights: form.highlights.split('\n').map((h) => h.trim()).filter(Boolean),
    metrics: form.metrics.filter((m) => m.label && m.value),
  };
  try {
    if (editing.value) {
      await adminApi.updateProject(editing.value.slug, payload as never);
    } else {
      await adminApi.createProject(payload as never);
    }
    modalOpen.value = false;
    await loadAll();
  } catch (e) {
    errors.value = extractValidationErrors(e);
    formError.value = Object.keys(errors.value).length ? 'Please fix the highlighted fields.' : extractMessage(e);
  } finally {
    saving.value = false;
  }
}

async function remove(project: Project): Promise<void> {
  if (!confirm(`Delete "${project.title}"? This cannot be undone.`)) return;
  await adminApi.deleteProject(project.slug);
  await loadAll();
}

onMounted(loadAll);
</script>

<template>
  <div>
    <AdminHeader title="Projects" subtitle="Manage the case studies shown on your portfolio.">
      <template #actions>
        <button class="btn-primary" @click="openCreate">
          <AppIcon name="plus" :size="16" /> New project
        </button>
      </template>
    </AdminHeader>

    <p v-if="loading" class="text-slate-500">Loading…</p>

    <div v-else class="glass overflow-hidden rounded-2xl">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-slate-500">
          <tr>
            <th class="px-5 py-3">Title</th>
            <th class="hidden px-5 py-3 sm:table-cell">Category</th>
            <th class="hidden px-5 py-3 md:table-cell">Year</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
          <tr v-for="project in projects" :key="project.id" class="hover:bg-white/[0.02]">
            <td class="px-5 py-3">
              <p class="font-medium text-white">{{ project.title }}</p>
              <p class="text-xs text-slate-500">{{ project.slug }}</p>
            </td>
            <td class="hidden px-5 py-3 text-slate-400 sm:table-cell">{{ project.category || '—' }}</td>
            <td class="hidden px-5 py-3 text-slate-400 md:table-cell">{{ project.year || '—' }}</td>
            <td class="px-5 py-3">
              <span class="chip text-[11px]" :class="project.is_published ? 'text-green-400' : 'text-slate-500'">
                {{ project.is_published ? 'Published' : 'Draft' }}
              </span>
              <span v-if="project.is_featured" class="chip ml-1 text-[11px] text-brand-400">Featured</span>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-1">
                <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-white/5 hover:text-white" @click="openEdit(project)">
                  <AppIcon name="edit" :size="16" />
                </button>
                <button class="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-400" @click="remove(project)">
                  <AppIcon name="trash" :size="16" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AdminModal :open="modalOpen" :title="editing ? 'Edit project' : 'New project'" @close="modalOpen = false">
      <form class="max-h-[70vh] space-y-4 overflow-y-auto pr-1" @submit.prevent="save">
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Title</span>
            <input v-model="form.title" class="field" type="text" />
            <span v-if="errors.title" class="mt-1 block text-xs text-red-400">{{ errors.title }}</span>
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Category</span>
            <input v-model="form.category" class="field" type="text" />
          </label>
        </div>

        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Tagline</span>
          <input v-model="form.tagline" class="field" type="text" />
          <span v-if="errors.tagline" class="mt-1 block text-xs text-red-400">{{ errors.tagline }}</span>
        </label>

        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Summary</span>
          <textarea v-model="form.summary" class="field" rows="2" />
          <span v-if="errors.summary" class="mt-1 block text-xs text-red-400">{{ errors.summary }}</span>
        </label>

        <div class="grid gap-4 sm:grid-cols-3">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Role</span>
            <input v-model="form.role" class="field" type="text" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Client</span>
            <input v-model="form.client" class="field" type="text" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Year</span>
            <input v-model.number="form.year" class="field" type="number" />
          </label>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Problem</span>
            <textarea v-model="form.problem" class="field" rows="3" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Solution</span>
            <textarea v-model="form.solution" class="field" rows="3" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Outcome</span>
            <textarea v-model="form.outcome" class="field" rows="3" />
          </label>
        </div>

        <label class="block">
          <span class="mb-1.5 block text-sm text-slate-300">Highlights (one per line)</span>
          <textarea v-model="form.highlights" class="field" rows="3" />
        </label>

        <div>
          <div class="mb-1.5 flex items-center justify-between">
            <span class="text-sm text-slate-300">Metrics</span>
            <button type="button" class="text-xs text-accent-400 hover:text-accent-300" @click="addMetric">+ Add metric</button>
          </div>
          <div v-for="(metric, i) in form.metrics" :key="i" class="mb-2 flex gap-2">
            <input v-model="metric.label" class="field" type="text" placeholder="Label (e.g. Models)" />
            <input v-model="metric.value" class="field" type="text" placeholder="Value (e.g. 52)" />
            <button type="button" class="grid h-10 w-10 shrink-0 place-items-center rounded-lg text-slate-400 hover:text-red-400" @click="removeMetric(i)">
              <AppIcon name="trash" :size="16" />
            </button>
          </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Live URL</span>
            <input v-model="form.live_url" class="field" type="url" />
          </label>
          <label class="block">
            <span class="mb-1.5 block text-sm text-slate-300">Repo URL</span>
            <input v-model="form.repo_url" class="field" type="url" />
          </label>
        </div>

        <div>
          <span class="mb-2 block text-sm text-slate-300">Tech stack</span>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="skill in skills"
              :key="skill.id"
              type="button"
              class="chip transition-colors"
              :class="form.skill_ids.includes(skill.id) ? 'border-accent-500/50 bg-accent-500/10 text-accent-300' : ''"
              @click="toggleSkill(skill.id)"
            >
              {{ skill.name }}
            </button>
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-6">
          <label class="flex items-center gap-2 text-sm text-slate-300">
            <input v-model="form.is_published" type="checkbox" class="h-4 w-4 rounded border-white/20 bg-base-850" /> Published
          </label>
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
          <button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save project' }}</button>
        </div>
      </form>
    </AdminModal>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import SectionHeading from '@/components/ui/SectionHeading.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import { publicApi } from '@/services/publicApi';
import { extractMessage, extractValidationErrors } from '@/services/api';
import type { Profile } from '@/types';

defineProps<{ profile: Profile }>();

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: '',
  website: '', // honeypot
});

const errors = ref<Record<string, string>>({});
const status = ref<'idle' | 'sending' | 'success' | 'error'>('idle');
const feedback = ref('');

async function submit(): Promise<void> {
  status.value = 'sending';
  errors.value = {};
  feedback.value = '';
  try {
    feedback.value = await publicApi.sendContact({ ...form });
    status.value = 'success';
    form.name = form.email = form.subject = form.message = '';
  } catch (e) {
    errors.value = extractValidationErrors(e);
    feedback.value = Object.keys(errors.value).length ? '' : extractMessage(e);
    status.value = 'error';
  }
}
</script>

<template>
  <section id="contact" class="scroll-mt-20 border-t border-white/5 py-20 sm:py-28">
    <div class="container-page grid gap-12 lg:grid-cols-[1fr_1.1fr]">
      <div>
        <SectionHeading
          eyebrow="Contact"
          title="Let's build something great"
          subtitle="Have a project in mind or a role to fill? I'd love to hear about it."
        />

        <div class="mt-8 space-y-4">
          <a
            v-if="profile.email"
            :href="`mailto:${profile.email}`"
            class="glass card-hover flex items-center gap-3 rounded-xl p-4"
          >
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-accent-500/10 text-accent-400">
              <AppIcon name="mail" :size="20" />
            </span>
            <div>
              <p class="text-xs text-slate-500">Email</p>
              <p class="text-sm font-medium text-white">{{ profile.email }}</p>
            </div>
          </a>

          <div class="flex gap-3">
            <a
              v-if="profile.social.github"
              :href="profile.social.github"
              target="_blank"
              rel="noopener"
              class="glass card-hover grid h-12 w-12 place-items-center rounded-xl text-slate-300 hover:text-white"
              aria-label="GitHub"
            >
              <AppIcon name="github" :size="22" />
            </a>
            <a
              v-if="profile.social.linkedin"
              :href="profile.social.linkedin"
              target="_blank"
              rel="noopener"
              class="glass card-hover grid h-12 w-12 place-items-center rounded-xl text-slate-300 hover:text-white"
              aria-label="LinkedIn"
            >
              <AppIcon name="linkedin" :size="22" />
            </a>
          </div>
        </div>
      </div>

      <form v-reveal="100" class="glass rounded-2xl p-6 sm:p-8" novalidate @submit.prevent="submit">
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm text-slate-300" for="name">Name</label>
            <input id="name" v-model="form.name" class="field" type="text" autocomplete="name" />
            <p v-if="errors.name" class="mt-1 text-xs text-red-400">{{ errors.name }}</p>
          </div>
          <div>
            <label class="mb-1.5 block text-sm text-slate-300" for="email">Email</label>
            <input id="email" v-model="form.email" class="field" type="email" autocomplete="email" />
            <p v-if="errors.email" class="mt-1 text-xs text-red-400">{{ errors.email }}</p>
          </div>
        </div>

        <div class="mt-4">
          <label class="mb-1.5 block text-sm text-slate-300" for="subject">Subject</label>
          <input id="subject" v-model="form.subject" class="field" type="text" />
          <p v-if="errors.subject" class="mt-1 text-xs text-red-400">{{ errors.subject }}</p>
        </div>

        <div class="mt-4">
          <label class="mb-1.5 block text-sm text-slate-300" for="message">Message</label>
          <textarea id="message" v-model="form.message" class="field min-h-32" rows="5" />
          <p v-if="errors.message" class="mt-1 text-xs text-red-400">{{ errors.message }}</p>
        </div>

        <!-- Honeypot: hidden from real users -->
        <input v-model="form.website" class="hidden" type="text" tabindex="-1" autocomplete="off" aria-hidden="true" />

        <button class="btn-primary mt-6 w-full" type="submit" :disabled="status === 'sending'">
          <span v-if="status === 'sending'">Sending…</span>
          <span v-else class="flex items-center gap-2">
            Send message
            <AppIcon name="arrowRight" :size="16" />
          </span>
        </button>

        <p v-if="status === 'success'" class="mt-4 flex items-center gap-2 text-sm text-green-400">
          <AppIcon name="check" :size="16" />
          {{ feedback }}
        </p>
        <p v-else-if="status === 'error' && feedback" class="mt-4 text-sm text-red-400">{{ feedback }}</p>
      </form>
    </div>
  </section>
</template>

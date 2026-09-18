<script setup lang="ts">
import { reactive, ref } from 'vue';
import SectionHeading from '@/components/ui/SectionHeading.vue';
import AppIcon from '@/components/ui/AppIcon.vue';
import type { Profile } from '@/types';

defineProps<{ profile: Profile }>();

const form = reactive({
    name: '',
    email: '',
    subject: '',
    message: '',
    website: '',
});

const errors = ref<Record<string, string>>({});
const status = ref<'idle' | 'sending' | 'success' | 'error'>('idle');
const feedback = ref('');

function encode(payload: Record<string, string>): string {
    return Object.entries(payload)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');
}

function validate(): Record<string, string> {
    const next: Record<string, string> = {};
    if (!form.name.trim()) next.name = 'Please enter your name.';
    if (!form.email.trim()) next.email = 'Please enter your email.';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) next.email = 'Please enter a valid email.';
    if (form.message.trim().length < 10) next.message = 'Please write a slightly longer message.';
    return next;
}

function isLocalHost(): boolean {
    return /^(localhost|127\.0\.0\.1)$/.test(window.location.hostname);
}

async function submit(): Promise<void> {
    status.value = 'sending';
    errors.value = {};
    feedback.value = '';

    const nextErrors = validate();
    if (Object.keys(nextErrors).length) {
        errors.value = nextErrors;
        status.value = 'error';
        return;
    }

    const body = encode({
        'form-name': 'contact',
        name: form.name,
        email: form.email,
        subject: form.subject,
        message: form.message,
        website: form.website,
    });

    try {
        const response = await fetch('/__forms.html', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body,
        });

        if (!response.ok && !isLocalHost()) {
            throw new Error('Request failed');
        }

        status.value = 'success';
        feedback.value = 'Thanks — your message is on its way. I will get back to you soon.';
        form.name = form.email = form.subject = form.message = '';
    } catch {
        status.value = 'error';
        feedback.value = 'Could not send the message. Please email me directly instead.';
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
              <p class="text-xs text-slate-400">Email</p>
              <p class="text-sm font-medium text-white">{{ profile.email }}</p>
            </div>
          </a>

          <a
            v-if="profile.phone"
            :href="`tel:${profile.phone.replace(/\s+/g, '')}`"
            class="glass card-hover flex items-center gap-3 rounded-xl p-4"
          >
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-accent-500/10 text-accent-400">
              <AppIcon name="phone" :size="20" />
            </span>
            <div>
              <p class="text-xs text-slate-400">Phone</p>
              <p class="text-sm font-medium text-white">{{ profile.phone }}</p>
            </div>
          </a>

          <div v-if="profile.location" class="glass flex items-center gap-3 rounded-xl p-4">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-accent-500/10 text-accent-400">
              <AppIcon name="location" :size="20" />
            </span>
            <div>
              <p class="text-xs text-slate-400">Location</p>
              <p class="text-sm font-medium text-white">{{ profile.location }}</p>
            </div>
          </div>

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
            <input id="name" v-model="form.name" name="name" class="field" type="text" autocomplete="name" />
            <p v-if="errors.name" class="mt-1 text-xs text-red-400">{{ errors.name }}</p>
          </div>
          <div>
            <label class="mb-1.5 block text-sm text-slate-300" for="email">Email</label>
            <input id="email" v-model="form.email" name="email" class="field" type="email" autocomplete="email" />
            <p v-if="errors.email" class="mt-1 text-xs text-red-400">{{ errors.email }}</p>
          </div>
        </div>

        <div class="mt-4">
          <label class="mb-1.5 block text-sm text-slate-300" for="subject">Subject</label>
          <input id="subject" v-model="form.subject" name="subject" class="field" type="text" />
          <p v-if="errors.subject" class="mt-1 text-xs text-red-400">{{ errors.subject }}</p>
        </div>

        <div class="mt-4">
          <label class="mb-1.5 block text-sm text-slate-300" for="message">Message</label>
          <textarea id="message" v-model="form.message" name="message" class="field min-h-32" rows="5" />
          <p v-if="errors.message" class="mt-1 text-xs text-red-400">{{ errors.message }}</p>
        </div>

        <input
          v-model="form.website"
          class="hidden"
          type="text"
          name="website"
          tabindex="-1"
          autocomplete="off"
          aria-hidden="true"
        />

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

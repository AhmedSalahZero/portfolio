<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { extractMessage } from '@/services/api';
import AppIcon from '@/components/ui/AppIcon.vue';

const auth = useAuthStore();
const router = useRouter();
const route = useRoute();

const form = reactive({ email: '', password: '' });
const loading = ref(false);
const error = ref('');

async function submit(): Promise<void> {
  loading.value = true;
  error.value = '';
  try {
    await auth.login(form.email, form.password);
    const redirect = (route.query.redirect as string) || '/admin/dashboard';
    router.push(redirect);
  } catch (e) {
    error.value = extractMessage(e, 'Unable to sign in.');
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="grid min-h-screen place-items-center px-6">
    <div class="w-full max-w-sm">
      <div class="mb-8 text-center">
        <span class="grid h-12 w-12 mx-auto place-items-center rounded-xl bg-gradient-to-br from-accent-500 to-brand-500 text-base-950">
          <AppIcon name="layers" :size="24" />
        </span>
        <h1 class="mt-4 text-2xl font-bold text-white">Admin sign in</h1>
        <p class="mt-1 text-sm text-slate-500">Manage your portfolio content</p>
      </div>

      <form class="glass rounded-2xl p-6" novalidate @submit.prevent="submit">
        <div>
          <label class="mb-1.5 block text-sm text-slate-300" for="email">Email</label>
          <input id="email" v-model="form.email" class="field" type="email" autocomplete="username" required />
        </div>
        <div class="mt-4">
          <label class="mb-1.5 block text-sm text-slate-300" for="password">Password</label>
          <input id="password" v-model="form.password" class="field" type="password" autocomplete="current-password" required />
        </div>

        <p v-if="error" class="mt-4 text-sm text-red-400">{{ error }}</p>

        <button class="btn-primary mt-6 w-full" type="submit" :disabled="loading">
          {{ loading ? 'Signing in…' : 'Sign in' }}
        </button>
      </form>

      <p class="mt-6 text-center text-xs text-slate-600">
        Default seed: admin@portfolio.test / password
      </p>
    </div>
  </div>
</template>

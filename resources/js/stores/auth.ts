import { defineStore } from 'pinia';
import { computed, ref } from 'vue';
import { adminApi } from '@/services/adminApi';
import { getStoredToken, setStoredToken } from '@/services/api';
import type { AdminUser } from '@/types';

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(getStoredToken());
  const user = ref<AdminUser | null>(null);

  const isAuthenticated = computed(() => !!token.value && !!user.value);

  function setToken(value: string | null): void {
    token.value = value;
    setStoredToken(value);
  }

  async function login(email: string, password: string): Promise<void> {
    const result = await adminApi.login(email, password);
    setToken(result.token);
    user.value = result.user;
  }

  async function fetchUser(): Promise<void> {
    if (!token.value) return;
    user.value = await adminApi.me();
  }

  async function logout(): Promise<void> {
    try {
      if (token.value) await adminApi.logout();
    } finally {
      reset();
    }
  }

  function reset(): void {
    setToken(null);
    user.value = null;
  }

  return { token, user, isAuthenticated, login, fetchUser, logout, reset };
});

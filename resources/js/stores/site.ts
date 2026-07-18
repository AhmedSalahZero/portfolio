import { defineStore } from 'pinia';
import { ref } from 'vue';
import { publicApi } from '@/services/publicApi';
import type { SiteData } from '@/types';

export const useSiteStore = defineStore('site', () => {
  const data = ref<SiteData | null>(null);
  const loading = ref(false);
  const error = ref<string | null>(null);
  const loaded = ref(false);

  async function load(force = false): Promise<void> {
    if (loaded.value && !force) return;
    loading.value = true;
    error.value = null;
    try {
      data.value = await publicApi.site();
      loaded.value = true;
    } catch (e) {
      error.value = 'Failed to load content. Please try again.';
    } finally {
      loading.value = false;
    }
  }

  return { data, loading, error, loaded, load };
});

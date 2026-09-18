import { defineStore } from 'pinia';
import { ref } from 'vue';
import { siteData } from '@/data/site';
import type { Project, SiteData } from '@/types';

export const useSiteStore = defineStore('site', () => {
    const data = ref<SiteData>(siteData);
    const loading = ref(false);
    const error = ref<string | null>(null);
    const loaded = ref(true);

    function load(_force = false): void {
        data.value = siteData;
        loaded.value = true;
        error.value = null;
        loading.value = false;
    }

    function projectBySlug(slug: string): Project | undefined {
        return data.value.projects.find((project) => project.slug === slug);
    }

    return { data, loading, error, loaded, load, projectBySlug };
});

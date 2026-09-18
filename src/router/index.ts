import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/views/HomeView.vue'),
        meta: { title: 'Home' },
    },
    {
        path: '/projects/:slug',
        name: 'project',
        component: () => import('@/views/ProjectView.vue'),
        props: true,
        meta: { title: 'Case Study' },
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@/views/NotFoundView.vue'),
        meta: { title: 'Not Found' },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, _from, savedPosition) {
        if (savedPosition) return savedPosition;
        if (to.hash) return { el: to.hash, behavior: 'smooth', top: 80 };
        return { top: 0 };
    },
});

router.afterEach((to) => {
    const base = import.meta.env.VITE_APP_NAME || 'Portfolio';
    document.title = to.meta.title ? `${to.meta.title as string} · ${base}` : base;
});

export default router;

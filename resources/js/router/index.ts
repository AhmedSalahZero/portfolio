import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

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
    path: '/admin/login',
    name: 'admin.login',
    component: () => import('@/admin/views/LoginView.vue'),
    meta: { title: 'Admin Login', guestOnly: true },
  },
  {
    path: '/admin',
    component: () => import('@/admin/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: { name: 'admin.dashboard' } },
      { path: 'dashboard', name: 'admin.dashboard', component: () => import('@/admin/views/DashboardView.vue'), meta: { title: 'Dashboard' } },
      { path: 'projects', name: 'admin.projects', component: () => import('@/admin/views/ProjectsView.vue'), meta: { title: 'Projects' } },
      { path: 'skills', name: 'admin.skills', component: () => import('@/admin/views/SkillsView.vue'), meta: { title: 'Skills' } },
      { path: 'experiences', name: 'admin.experiences', component: () => import('@/admin/views/ExperiencesView.vue'), meta: { title: 'Experience' } },
      { path: 'messages', name: 'admin.messages', component: () => import('@/admin/views/MessagesView.vue'), meta: { title: 'Messages' } },
    ],
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

router.beforeEach(async (to) => {
  const auth = useAuthStore();

  if (auth.token && !auth.user) {
    await auth.fetchUser().catch(() => auth.reset());
  }

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: 'admin.login', query: { redirect: to.fullPath } };
  }

  if (to.meta.guestOnly && auth.isAuthenticated) {
    return { name: 'admin.dashboard' };
  }

  return true;
});

router.afterEach((to) => {
  const base = (import.meta.env.VITE_APP_NAME as string | undefined) || 'Portfolio';
  document.title = to.meta.title ? `${to.meta.title as string} · ${base}` : base;
});

export default router;

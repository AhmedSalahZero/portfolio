import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from '@/router';
import App from '@/App.vue';
import { vReveal } from '@/composables/useReveal';
import { setUnauthorizedHandler } from '@/services/api';
import { useAuthStore } from '@/stores/auth';
import '../css/app.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

app.directive('reveal', vReveal);

// On any 401 from the API, drop the session and bounce to the login screen.
setUnauthorizedHandler(() => {
  const auth = useAuthStore(pinia);
  auth.reset();
  if (router.currentRoute.value.meta.requiresAuth) {
    router.push({ name: 'admin.login' });
  }
});

app.mount('#app');

import 'bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import { Api } from '@/api';

const app = createApp(App);

let api = new Api();

app.use(createPinia());
app.use(router);
app.provide('api', api);

router.beforeEach(async (route) => {
    if (route.meta.allowedRoles) {
        await api.userLoaded;

        if (!api.user || !route.meta.allowedRoles.includes(api.user.role)) {
            console.log('Redirecting... :', api.user);
            return { name: 'home' };
        }

        console.log('allowed...');
    }

    return true;
});

app.mount('#app');

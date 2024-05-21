import 'bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import { Api } from '@/api';

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

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

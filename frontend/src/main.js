import 'bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import { Api } from '@/api';

import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

let echo = new Echo({
    broadcaster: 'pusher',
    key: '48e6c4042b5829fecd9f',
    cluster: 'eu',
    forceTLS: true,
    authEndpoint: 'http://localhost:8000/broadcasting/auth',
});

const app = createApp(App);

let api = new Api();

app.use(createPinia());
app.use(router);
app.provide('api', api);
app.provide('echo', echo);

router.beforeEach(async (route) => {
    if (route.meta.allowedRoles) {
        await api.userLoaded;

        if (!api.user.value || !route.meta.allowedRoles.includes(api.user.value.role)) {
            console.log('Redirecting... :', api.user.value);
            return { name: 'home' };
        }

        console.log('allowed...');
    }

    return true;
});

app.mount('#app');

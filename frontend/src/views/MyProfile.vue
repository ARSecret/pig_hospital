<script setup>
import { computed, ref, inject } from 'vue';

let api = inject('api');

let role = computed(() => {
    switch (api.user.value.role) {
        case 'doctor':
            return 'врач';
        case 'patient':
            return 'пациент';
        default:
            return 'неизвестный';
    }
});
</script>

<template>
    <div v-if="api.user">
        Вы: {{ role }} {{ api.user.value.fullName }}<br>
        Ваш логин: {{ api.user.value.username }}
    </div>
</template>
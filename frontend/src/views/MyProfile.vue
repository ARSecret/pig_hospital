<script setup lang="ts">
import { useApi } from '@/stores/api';
import { computed, ref, type Ref } from 'vue';

let api = useApi();

let role = computed(() => {
    switch (api.user.role) {
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
        Вы: {{ role }} {{ api.user.full_name }}<br>
        Ваш логин: {{ api.user.login }}
    </div>
</template>

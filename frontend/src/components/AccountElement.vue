<script setup lang="ts">
import { useApi } from '@/stores/api';
import { RouterLink } from 'vue-router';

let api = useApi();

let props = defineProps<{
    loginModalId: string,
}>();

function logout() {
    api.logout();
    console.log('Logged out');
}
</script>

<template>
    <div v-if="api.user" class="d-flex">
        <div class="dropdown me-2">
            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">{{ api.user.login }}</button>
            <ul class="dropdown-menu">
                <li>
                    <RouterLink :to="{ name: 'my-profile' }" class="dropdown-item">Личный кабинет</RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'my-patients' }" class="dropdown-item" v-if="api.user.role == 'doctor'">Мои пациенты
                    </RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'my-appointments' }" class="dropdown-item" v-if="api.user.role == 'doctor'">Мои приемы
                    </RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'patient-appointments' }" class="dropdown-item" v-if="api.user.role == 'patient'">Мои записи
                    </RouterLink>
                </li>
            </ul>
        </div>

        <button class="btn btn-secondary" @click="logout">Выйти</button>
    </div>

    <div v-else class="btn-group">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" :data-bs-target="'#' + props.loginModalId">
            Войти
        </button>
        <button class="btn btn-primary">
            Зарегистрироваться
        </button>
    </div>
</template>

<style lang="scss"></style>

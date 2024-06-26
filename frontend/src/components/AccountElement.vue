<script setup>
import * as bootstrap from 'bootstrap';
import { inject, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

function logout() {
    api.logOut();
    console.log('Logged out');
    router.push({ name: 'home' });
}

let api = inject('api');
let router = useRouter();
let user = api.user;


function collapseNavbar() {
    let collapseElement = document.querySelector('#navbarSupportedContent');
    collapseElement = new bootstrap.Collapse(collapseElement);
    collapseElement.hide();
}

defineProps(['loginModalId']);

console.log(api.user.value);
</script>

<template>
    <div v-if="user" class="d-flex">
        <div class="dropdown me-2">
            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                {{ user.username }}
            </button>
            <ul class="dropdown-menu">
                <li>
                    <RouterLink :to="{ name: 'my-profile' }" class="dropdown-item" @click="collapseNavbar"
                        >Личный кабинет</RouterLink
                    >
                </li>
                <li>
                    <RouterLink
                        v-if="user.role == 'doctor'"
                        :to="{ name: 'my-patients' }"
                        class="dropdown-item" @click="collapseNavbar"
                        >Мои пациенты
                    </RouterLink>
                </li>
                <li>
                    <RouterLink
                        v-if="user.role == 'doctor'"
                        :to="{ name: 'my-appointments' }"
                        class="dropdown-item" @click="collapseNavbar"
                        >Мои приемы
                    </RouterLink>
                </li>
                <li>
                    <RouterLink
                        v-if="user.role == 'patient'"
                        :to="{ name: 'patient-appointments' }"
                        class="dropdown-item" @click="collapseNavbar"
                        >Мои записи
                    </RouterLink>
                </li>

                <li>
                    <RouterLink
                        v-if="user.role == 'patient'"
                        :to="{ name: 'my-case-records', params: { patientId: user.patientId } }"
                        class="dropdown-item" @click="collapseNavbar"
                    >
                        Моя история болезни
                    </RouterLink>
                </li>
            </ul>
        </div>

        <button class="btn btn-secondary" @click="logout">Выйти</button>
    </div>

    <div v-else class="btn-group">
        <button
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            :data-bs-target="'#' + loginModalId"
        >
            Войти
        </button>
        <RouterLink :to="{ name: 'join' }" class="btn btn-primary">Зарегистрироваться</RouterLink>
    </div>
</template>

<style lang="scss"></style>

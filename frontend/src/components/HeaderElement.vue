<script setup>
import { ref, inject } from 'vue';

import AccountElement from '@/components/AccountElement.vue';
import LoginModal from '@/components/LoginModal.vue';

const LOGIN_MODAL_ID = 'my-login-modal';

// let api = inject('api');
</script>

<template>
    <div class="navbar navbar-expand-lg border-bottom fixed-top bg-body-tertiary">
        <div class="container">
            <a href="" class="navbar-brand">
                <img
                    alt="Логотип больницы"
                    class="logo d-inline-block align-text-center"
                    src="@/assets/pig-logo.png"
                    width="82"
                    height="82"
                />
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink to="/" class="nav-link">Главная</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/doctors" class="nav-link">Врачи</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/specialities" class="nav-link">Специальности</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/about" class="nav-link">О больнице</RouterLink>
                    </li>
                </ul>
                <AccountElement :login-modal-id="LOGIN_MODAL_ID" />
            </div>
        </div>
    </div>

    <LoginModal :id="LOGIN_MODAL_ID" />
</template>

<style lang="scss"></style>
@/api

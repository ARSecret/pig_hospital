<script setup lang="ts">
import { provide } from 'vue';

import { RouterLink, RouterView } from 'vue-router'
import HeaderElement from './components/HeaderElement.vue'
</script>

<template>
    <div>
        <HeaderElement />
        <main class="container py-4">
            <RouterView />
        </main>
    </div>
</template>

<style lang="scss">
$primary: #ff0060;

@import "bootstrap/scss/bootstrap";

main {
    margin-top: 109px;
}
</style>

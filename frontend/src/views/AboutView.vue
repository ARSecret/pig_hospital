<script setup lang="ts">
import { useApi } from '@/stores/api';
import { ref } from 'vue';

let api = useApi();

let text = ref('');

api.getAboutText().then(result => {
    text.value = result;
});
</script>

<template>
    {{ text }}
</template>

<style lang="scss">
</style>
@/api
<script setup>
import { useRouter, useRoute } from 'vue-router';
import { ref, inject } from 'vue';

import { getDoctorImageUrl } from '@/functions';

let api = inject('api');
let route = useRoute();

let doctor = ref(undefined);

let doctorId = route.params.id;
api.getDoctor(doctorId).then((result) => {
    doctor.value = result;
});
</script>

<template>
    div
</template>

<style lang="scss"></style>

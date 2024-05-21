<script setup>
import { inject } from 'vue';

import { getDoctorImageUrl } from '@/functions';

let { doctor } = defineProps(['doctor']);

let api = inject('api');
console.log(api.user.value.role);
</script>

<template>
    <div class="card">
        <div
            :style="{
                'background-image': `url(${getDoctorImageUrl(doctor)})`,
            }"
            style="background-position: center; background-size: cover; --bs-aspect-ratio: 130%"
            alt=""
            class="card-img-top ratio"
        ></div>
        <div class="card-body">
            <h5 class="card-title text-nowrap overflow-hidden">{{ doctor.fullName }}</h5>
            <p class="card-text text-nowrap">{{ doctor.speciality.name }}</p>
            <RouterLink
                v-if="api.user.value.role == 'patient'"
                :to="{ name: 'doctor-appointments', params: { doctorId: doctor.id } }"
                class="btn btn-primary"
            >
                Записаться
            </RouterLink>
        </div>
    </div>
</template>

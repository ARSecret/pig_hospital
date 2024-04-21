<script setup>
import { computed, inject } from 'vue';

let { doctor } = defineProps(['doctor']);

let imageUrl = computed(() => {
    if (doctor.photoUrl) {
        return doctor.photoUrl;
    }

    return `/default-doctor-${doctor.gender}.jpg`;
});

let api = inject('api');
</script>

<template>
    <div class="card">
        <div
            :style="{
                'background-image': `url(${imageUrl})`,
            }"
            style="background-position: center; background-size: cover; --bs-aspect-ratio: 130%"
            alt=""
            class="card-img-top ratio"
        ></div>
        <div class="card-body">
            <h5 class="card-title text-nowrap overflow-hidden">{{ doctor.fullName }}</h5>
            <p class="card-text text-nowrap">{{ doctor.speciality.name }}</p>
            <RouterLink
                v-if="api.user"
                :to="{ name: 'doctor-appointments', params: { doctorId: doctor.id } }"
                class="btn btn-primary"
            >
                Подробнее
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref, inject } from 'vue';

import DoctorCard from '@/components/DoctorCard.vue';

function loadDoctors() {
    speciality.value = null;
    doctors.value = [];
    
    let queryParams = new URL(document.location.href).searchParams;
    let specialityId = queryParams.get('speciality_id');
    
    if (specialityId) {
        api.getSpeciality(specialityId).then((result) => {
            speciality.value = result;
        });
    }

    api.getDoctors(specialityId).then((result) => {
        doctors.value = result;
        console.log('Doctors:', doctors.value);
    });
}

async function removeSpecialityFilter() {
    await router.replace({ name: 'doctors' });
    loadDoctors();
}

let api = inject('api');
let router = useRouter();

let speciality = ref(null);
let doctors = ref(null);

loadDoctors();
</script>

<template>
    <div v-if="!doctors">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <div v-for="_ in 8" :key="_" class="col">
                <div class="card">
                    <img alt="" class="card-img-top placeholder" height="250px" />
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-8"></span>
                        </p>
                        <a href="" class="btn btn-primary disabled">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else>
        <div
            v-if="speciality"
            class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2"
        >
            {{ speciality.name }}
            <button class="btn-close" @click="removeSpecialityFilter"></button>
        </div>

        <div class="row g-4">
            <div
                v-for="doctor in doctors"
                :key="doctor.id"
                class="col-12 col-md-6 col-lg-4 col-xl-3"
            >
                <DoctorCard :doctor />
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>

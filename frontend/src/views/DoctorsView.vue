<script setup lang="ts">
import { type Ref, ref } from 'vue';

import { useApi, type Speciality } from '@/stores/api';

let api = useApi();

let speciality: Ref<Speciality | null> = ref(null);
let doctors: Ref<any[]> = ref([]);


reloadDoctors();


function getDoctorImageUrl(doctor: any): string {
    if (doctor.photo_url) {
        return doctor.photo_url;
    }

    return `/default-doctor-${doctor.gender}.jpg`;
}

function reloadDoctors() {
    speciality.value = null;
    doctors.value = [];

    let queryParams = new URL(document.location.href).searchParams;
    let specialityId = queryParams.get('speciality_id');
    
    if (specialityId) {
        api.getSpeciality(specialityId).then(result => {
            speciality.value = result;
        });
    }

    api.getAllDoctors(specialityId).then(result => {
        doctors.value = result;
    });
}

function removeSpecialityFilter() {
    let url = new URL(document.location.href);
    url.searchParams.delete('speciality_id');
    document.location.href = url.href;
    
}

</script>

<template>
    <div v-if="!doctors.length">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <div class="col" v-for="_ in 8">
                <div class="card">
                    <img alt="" class="card-img-top placeholder" height="250px">
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
        <div v-if="speciality"
            class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2">
            {{ speciality.name }}
            <button class="btn-close" @click="removeSpecialityFilter"></button>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <div class="col" v-for="doctor in doctors">
                <div class="card">
                    <img :src="getDoctorImageUrl(doctor)" alt="" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title text-nowrap">{{ doctor.full_name }}</h5>
                        <p class="card-text text-nowrap">{{ doctor.speciality.name }}</p>
                        <RouterLink :to="{name: 'doctor-appointments', params: {doctorId: doctor.id}}" class="btn btn-primary">Подробнее</RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>

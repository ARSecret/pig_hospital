<script setup>
import { ref, inject } from 'vue';

let api = inject('api');

let patients = ref([]);

api.getAllDoctorPatients().then((result) => {
    patients.value = result;
});
</script>

<template>
    <div v-if="!patients.length" class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <div class="col" v-for="_ in 8" :key="_">
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
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <div v-for="patient in patients" :key="patient.id" class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-nowrap">{{ patient.full_name }}</h5>
                    <p class="card-text text-nowrap">{{ patient.birthdate }}</p>
                    <RouterLink
                        :to="{ name: 'case-records', params: { patientId: patient.id } }"
                        class="btn btn-primary d-flex"
                        >История болезни</RouterLink
                    >
                </div>
            </div>
        </div>
    </div>
</template>
../api

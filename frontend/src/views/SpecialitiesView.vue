<script setup>
import { ref, inject } from 'vue';

let api = inject('api');
let specialities = ref([]);
api.getSpecialities().then((result) => (specialities.value = result));
</script>

<template>
    <div class="row g-4">
        <div
            v-for="speciality in specialities"
            :key="speciality.id"
            class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex"
        >
            <div class="card">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-capitalize">{{ speciality.name }}</h5>
                    <p class="card-text">{{ speciality.description }}</p>
                    <RouterLink
                        :to="{ name: 'doctors', query: { speciality_id: speciality.id } }"
                        class="btn btn-primary mt-auto"
                        >Найти врачей</RouterLink
                    >
                </div>
            </div>
        </div>
    </div>
</template>

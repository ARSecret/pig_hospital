<script setup lang="ts">
import { useApi } from '@/stores/api';
import { type Ref, ref } from 'vue';

let api = useApi();
let specialities: Ref<any[]> = ref([]);
api.getAllSpecialities().then(result => specialities.value = result);

</script>

<template>
    <div class="row row-cols-4 g-4">
        <div class="col d-flex" v-for="speciality in specialities">
            <div class="card">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-capitalize">{{ speciality.name }}</h5>
                    <p class="card-text">{{ speciality.description }}</p>
                    <RouterLink :to="{ name: 'doctors', query: { 'speciality_id': speciality.id } }"
                        class="btn btn-primary mt-auto">Найти врачей</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

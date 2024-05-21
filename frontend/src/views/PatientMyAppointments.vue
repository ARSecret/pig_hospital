<script setup>
import { ref, watch, inject } from 'vue';

import { useRoute } from 'vue-router';

import NotFound from '@/components/NotFound.vue';

let api = inject('api');

let route = useRoute();

let appointments = ref(undefined);
console.log(route.query.date);
let dateString = ref(route.query.date || new Date().toISOString().split('T')[0]);

async function reloadData() {
    appointments.value = undefined;
    appointments.value = await api.getPatientAppointments(api.user.value.id, dateString.value);
    console.log('Appointments:', appointments.value);
}
reloadData();

watch(dateString, () => {
    reloadData();
});

async function cancelAppointment(appointmentId) {
    await api.cancelAppointment(appointmentId);
    reloadData();
}
</script>

<template>
    <div v-if="appointments === undefined">Loading...</div>
    <div v-else>
        <h3>Мои записи на прием</h3>

        <h4>Записи на <input v-model="dateString" type="date" />:</h4>
        <div v-if="!appointments.length">Пусто!</div>
        <div v-else>
            <div class="row g-4">
                <div v-for="appointment in appointments" :key="appointment.id" class="col-xs-12">
                    <div class="card d-flex">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ new Date(appointment.date_time).toLocaleTimeString() }}
                            </h5>
                            <p class="card-text">
                                <RouterLink
                                    :to="{
                                        name: 'doctor-appointments',
                                        params: { doctorId: appointment.doctor.id },
                                    }"
                                >
                                    {{ appointment.doctor.fullName }} ({{
                                        appointment.doctor.speciality.name
                                    }})
                                </RouterLink>
                            </p>
                            <p class="card-text">{{ appointment.pretty_status }}</p>
                            <div class="row g-3">
                                <div
                                    v-if="appointment.can_be_cancelled"
                                    class="col d-grid"
                                    @click="cancelAppointment(appointment.id)"
                                >
                                    <button class="btn btn-danger">Отменить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>
@/api

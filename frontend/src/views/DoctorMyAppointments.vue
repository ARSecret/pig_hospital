<script setup>
import { ref, watch, inject } from 'vue';

import { RouterLink } from 'vue-router';

import NotFound from '@/components/NotFound.vue';

let api = inject('api');

let appointments = ref(undefined);
let date = ref(new Date());
let dateString = ref(date.value.toISOString().split('T')[0]);

console.log('User:', api.user.value);

async function reloadData() {
    appointments.value = undefined;
    appointments.value = await api.getDoctorAppointments(api.user.value.doctorId, date.value);
    console.log(appointments.value);
}
reloadData();

watch(dateString, (newDateString) => {
    console.log('changed:', newDateString);
    date.value = new Date(newDateString);
    reloadData();
});

function getDoctorImageUrl(doctor) {
    if (doctor.photo_url) {
        return doctor.photo_url;
    }

    return `/default-doctor-${doctor.gender}.jpg`;
}

function removeSpecialityFilter() {
    let url = new URL(document.location.href);
    url.searchParams.delete('speciality_id');
    document.location.href = url.href;
}

// function addAppointment(datetimeString: string) {
//     api.addDoctorAppointment(doctor.value.id, new Date(datetimeString));
// }

function getAppointmentStatus(appointment) {
    switch (appointment.status) {
        case 'created':
            return 'Добавлена';
        case 'confirmed':
            return 'Подтверждено';
        case 'didnt-come':
            return 'Пациент не пришёл';
        case 'successful':
            return 'Прошёл успешно';
        case 'cancelled':
            return 'Отменена';
        default:
            return 'Неизвестный статус';
    }
}

function confirmAppointment(id) {
    api.confirmAppointment(id);
    appointments.value.find((appointment) => appointment.id == id).status = 'confirmed';
}

function cancelAppointment(id) {
    api.cancelAppointment(id);
    appointments.value.find((appointment) => appointment.id == id).status = 'cancelled';
}

function successAppointment(id) {
    api.successAppointment(id);
    appointments.value.find((appointment) => appointment.id == id).status = 'successful';
}

function setDidntComeAppointment(id) {
    api.setDidntComeAppointment(id);
    appointments.value.find((appointment) => appointment.id == id).status = 'didnt-come';
}
</script>

<template>
    <div v-if="appointments === undefined">Loading...</div>
    <div v-else>
        <h3>Мои записи на прием</h3>

        <h4>Записи на <input type="date" v-model="dateString" />:</h4>
        <div v-if="!appointments.length">Пусто!</div>
        <div v-else>
            <div class="row g-4">
                <div v-for="appointment in appointments" :key="appointment.id" class="col-xs-12">
                    <div class="card d-flex">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ new Date(appointment.dateTime).toLocaleTimeString() }}
                            </h5>
                            <p class="card-text">
                                {{ appointment.patient.fullName }} ({{ appointment.patient.age }})
                            </p>
                            <p class="card-text">{{ getAppointmentStatus(appointment) }}</p>
                            <div class="row g-3">
                                <div class="col d-grid" v-if="appointment.status == 'created'">
                                    <button
                                        class="btn btn-secondary pull-right"
                                        @click="confirmAppointment(appointment.id)"
                                    >
                                        Подтвердить
                                    </button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
                                    <button
                                        class="btn btn-success"
                                        @click="successAppointment(appointment.id)"
                                    >
                                        Завершено
                                    </button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
                                    <button
                                        class="btn btn-warning"
                                        @click="setDidntComeAppointment(appointment.id)"
                                    >
                                        Пациент не пришел
                                    </button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
                                    <button
                                        class="btn btn-danger"
                                        @click="cancelAppointment(appointment.id)"
                                    >
                                        Отменить
                                    </button>
                                </div>
                                <div v-if="appointment.status == 'confirmed'" class="col d-grid">
                                    <RouterLink
                                        :to="{
                                            name: 'video-call',
                                            params: { doctorId: api.user.value.doctorId },
                                        }"
                                        class="btn btn-secondary"
                                        >Онлайн</RouterLink
                                    >
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

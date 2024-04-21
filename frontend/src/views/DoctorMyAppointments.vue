<script setup lang="ts">
import { type Ref, ref, watch } from 'vue';

import { useApi, type Speciality } from '@/stores/api';
import { useRoute } from 'vue-router';

import NotFound from '@/components/NotFound.vue';

let api = useApi();

let appointments: Ref<any> = ref(undefined);
let date = ref(new Date);
let dateString = ref(date.value.toISOString().split('T')[0]);


async function reloadData() {
    appointments.value = undefined;
    appointments.value = await api.getDoctorAppointments(api.user.doctor.id, date.value);
    console.log(appointments.value);
}
reloadData();

watch(dateString, (newDateString) => {
    console.log('changed:', newDateString);
    date.value = new Date(newDateString);
    reloadData();
});


function getDoctorImageUrl(doctor: any): string {
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

function getAppointmentStatus(appointment: any) {
    switch (appointment.status) {
        case 'created':
            return 'Добавлена';
        case 'confirmed':
            return 'Подтверждено';
        default:
            return 'Неизвестный статус';
    }
}

function confirmAppointment(id: string) {
    api.confirmAppointment(id);
}

</script>

<template>
    <div v-if="appointments === undefined">Loading...</div>
    <div v-else>
        <h3>Мои записи на прием</h3>

        <h4>Записи на <input type="date" v-model="dateString">:</h4>
        <div v-if="!appointments.length">
            Пусто!
        </div>
        <div v-else>
            <div class="row g-4">
                <div v-for="appointment in appointments" class="col-xs-12">
                    <div class="card d-flex">
                        <div class="card-body">
                            <h5 class="card-title">{{ new Date(appointment.datetime).toLocaleTimeString() }}</h5>
                            <p class="card-text">{{ appointment.patient.full_name }} ({{ appointment.patient.age }})</p>
                            <p class="card-text">{{ getAppointmentStatus(appointment) }}</p>
                            <div class="row g-3">
                                <div class="col d-grid" v-if="appointment.status == 'created'">
                                    <button class="btn btn-secondary pull-right"
                                        @click="confirmAppointment(appointment.id)">Подтвердить</button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
                                    <button class="btn btn-success">Завершено</button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
                                    <button class="btn btn-warning">Пациент не пришел</button>
                                </div>
                                <div class="col d-grid" v-if="appointment.status == 'confirmed'">
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
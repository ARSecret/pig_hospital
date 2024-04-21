<script setup lang="ts">
import { type Ref, ref, watch } from 'vue';

import { useApi, type Speciality } from '@/stores/api';
import { useRoute, useRouter } from 'vue-router';

import NotFound from '@/components/NotFound.vue';

let api = useApi();

let doctor: Ref<any> = ref(undefined);
let availableAppointmentTimes: Ref<any> = ref(undefined);
let date = ref(new Date);
date.value.setDate(date.value.getDate() + 1);
let dateString = ref(date.value.toISOString().split('T')[0]);
console.log('initial:', dateString.value);

let route = useRoute();
let router = useRouter();


async function reloadData() {
    doctor.value = undefined;
    availableAppointmentTimes.value = undefined;


    let doctorId = route.params.doctorId as string;
    
    doctor.value = await api.getDoctor(doctorId);
    if (doctor.value === null) {
        return;
    }

    availableAppointmentTimes.value = await api.getDoctorAvailableAppointments(doctorId, date.value);
    console.log(availableAppointmentTimes.value);
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

function addAppointment(datetimeString: string) {
    api.addDoctorAppointment(doctor.value.id, datetimeString);
    console.log('added appointment');
    let dateString = datetimeString.split('T')[0];
    router.replace({
        name: 'patient-appointments',
        query: {
            date: dateString,
        },
    });
}

</script>

<template>
<NotFound v-if="doctor === null"></NotFound>
<div v-else-if="doctor === undefined">Loading...</div>
<div v-else>
    <h3>{{ doctor.full_name }}</h3>
    <h4 class="text-capitalize">{{ doctor.speciality.name }}</h4>
    
    <h4>Доступное время для записи на <input type="date" v-model="dateString">:</h4>
    <div v-if="availableAppointmentTimes === undefined">Loading...</div>
    <div v-else-if="!availableAppointmentTimes.length">
        Пусто!
    </div>
    <div v-else>
        <div class="row g-4">
            <div v-for="time in availableAppointmentTimes" class="col-xs-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body ">
                        <h5 class="card-title">{{ new Date(time).toLocaleTimeString() }}</h5>
                        <button class="btn btn-primary pull-right" @click="addAppointment(time)">Записаться</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style lang="scss"></style>
@/api
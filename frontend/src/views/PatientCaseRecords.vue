<script setup lang="ts">
import { useApi } from '@/stores/api';
import { computed, ref, type Ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import NotFound from '@/components/NotFound.vue';

let api = useApi();

let route = useRoute();

let patientId = route.params.patientId as string;

let patientNotFound = ref(false);
let caseRecordsLoaded = ref(false);

let patient: Ref<any> = ref(null);
let caseRecords: Ref<any[]> = ref([]);

function reload() {
    api.getPatient(patientId).then(result => {
        patient.value = null;
        if (result == null) {
            patientNotFound.value = true;
        } else {
            patient.value = result;
        }
    });
    api.getAllPatientCaseRecords(patientId).then(result => {
        caseRecords.value = [];
        if (result == null) {
            patientNotFound.value = true;
        } else {
            caseRecordsLoaded.value = true;
            caseRecords.value = result;
        }
    });
}
reload();




function getDateString(caseRecord: any) {
    let date = new Date(caseRecord.datetime);
    let day = date.getDate();
    let dayString = day.toString();
    if (day < 10) {
        dayString = '0' + dayString;
    }

    let month = date.getMonth();
    let monthString = month.toString();
    if (month < 10) {
        monthString = '0' + monthString;
    }

    return `${dayString}.${monthString}.${date.getFullYear()}`;
}

let newCaseRecordText = ref('');

function addNewCaseRecord(event: Event) {
    event.preventDefault();
    api.postPatientCaseRecord(patient.value.id, newCaseRecordText.value).then(result => {
        reload();
    });
}
</script>

<template>
    <NotFound v-if="patientNotFound"></NotFound>
    <div v-else>
        <div v-if="!patient">
            <h3 class="">Пациент <span class="placeholder col-4"></span></h3>
            <h4 class="mb-3">Возраст <span class="placeholder col-2"></span></h4>
        </div>
        <div v-else>
            <h3>Пациент {{ patient.full_name }}</h3>
            <h4 class="mb-3">Возраст {{ patient.age }}</h4>
        </div>
        <div v-if="!caseRecordsLoaded">
            <div class="row g-4">
                <div class="col-xs-12" v-for="_ in 4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title placeholder-glow">
                                <span class="placeholder col-4"></span>
                            </h5>
                            <h6 class="card-subtitle placeholder-glow">
                                <span class="placeholder col-6"></span>
                            </h6>
                            <p class="card-text placeholder-glow">
                                <span class="placeholder col-12"></span>
                                <span class="placeholder col-12"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row-gap-4 row">
                <div class="col">
                    <div class="card">
                        <form action="">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Новая запись</h5>
                                <h6 class="card-subtitle text-body-secondary mb-3">
                                    {{ api.user.doctor.full_name }} ({{ api.user.doctor.speciality.name }})
                                </h6>
                                <textarea v-model="newCaseRecordText" class="form-control mb-3" rows="3"></textarea>
                                <button class="btn btn-primary align-self-end" @click="addNewCaseRecord">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-if="caseRecords.length == 0">
                    Пусто!
                </div>
                <div v-for="caseRecord in caseRecords" class="col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ getDateString(caseRecord) }}</h5>
                            <h6 class="card-subtitle text-body-secondary">
                                {{ caseRecord.doctor.full_name }} ({{ caseRecord.doctor.speciality.name }})
                            </h6>
                            <p class="card-text">{{ caseRecord.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
@/api
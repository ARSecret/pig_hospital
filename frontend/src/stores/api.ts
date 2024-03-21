import { defineStore } from 'pinia';
import type { Ref } from 'vue';
import { ref } from 'vue';
import axios, { AxiosError } from 'axios';
import { useRouter } from 'vue-router';

export type Speciality = {
    id: string
    name: string
    description: string
};



export const useApi = defineStore('api', () => {
    const API_PREFIX = '/api';

    const axiosInstance = axios.create({
        baseURL: import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000',
        withCredentials: true,
        withXSRFToken: true,
    });
    const user: Ref<any> = ref(undefined);
    const userLoaded = new Promise((resolve, reject) => {
        axiosInstance.get(API_PREFIX + '/user').then(response => {
            user.value = response.data.data;
            resolve(user.value);
        })
            .catch(error => {
                user.value = null;
                resolve(null);
            });
    });

    async function getData(url: string, params: any = undefined): Promise<any> {
        try {
            const response = await axiosInstance.get(API_PREFIX + url, { params });
            return response.data.data;
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function getAllDoctors(specialityId: string | null = null): Promise<any[]> {
        const params = new URLSearchParams('');
        if (specialityId != null) {
            params.append('speciality_id', specialityId);
        }
        let paramsUrl = params.toString();
        if (paramsUrl != '') {
            paramsUrl = '?' + paramsUrl;
        }
        const response = await axiosInstance.get(API_PREFIX + '/doctors' + paramsUrl);
        return response.data.data;
    }

    async function getDoctor(doctorId: string): Promise<any> {
        try {
            return await getData(`/doctors/${doctorId}`);
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function getDoctorAppointments(doctorId: string, date: Date): Promise<any> {
        return (await axiosInstance.get(API_PREFIX + `/doctors/${doctorId}/appointments`, {
            params: {
                date: date.toISOString(),
            },
        })).data.data;
    }

    async function getDoctorAvailableAppointments(doctorId: string, date: Date): Promise<any> {
        try {
            const response = await axiosInstance.get(
                API_PREFIX + `/doctors/${doctorId}/available-appointments`,
                {
                    params: {
                        date: date.toISOString(),
                    },
                },
            );
            return response.data.data;
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function addDoctorAppointment(doctorId: string, datetime: string) {
        await axiosInstance.post(API_PREFIX + `/doctors/${doctorId}/appointments`, {
            datetime,
        });
    }

    async function getAllDoctorPatients() {
        return getData(`/doctors/${user.value.doctor.id}/patients`);
    }

    async function getPatient(patientId: string): Promise<any> {
        try {
            return await getData(`/patients/${patientId}`);
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function getAllPatientCaseRecords(patientId: string): Promise<any[] | null> {
        try {
            return await getData(`/patients/${patientId}/case-records`);
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function postPatientCaseRecord(patientId: string, caseRecordText: string) {
        console.log(patientId, caseRecordText);
        const response = await axiosInstance.post(API_PREFIX + `/patients/${patientId}/case-records`, {
            text: caseRecordText,
        });
        console.log(response);
    }

    async function getAllSpecialities(): Promise<any[]> {
        const response = await axiosInstance.get(API_PREFIX + '/specialities');
        return response.data.data;
    }

    async function getSpeciality(specialityId: string): Promise<Speciality | null> {
        try {
            return await getData(`/specialities/${specialityId}`);
        } catch (error: any) {
            if (error.response && error.response.status == 404) {
                return null;
            } else {
                throw error;
            }
        }
    }

    async function getAllNews(): Promise<any[]> {
        const response = await axiosInstance.get(API_PREFIX + '/news');
        return response.data.data;
    }

    async function getAboutText(): Promise<string> {
        const response = await axiosInstance.get(API_PREFIX + '/about');
        return response.data.data;
    }

    async function attemptLogin(login: string, password: string): Promise<boolean> {
        const csrfResponse = await axiosInstance.get('/sanctum/csrf-cookie');
        console.log('Csrf Response:', csrfResponse);
        try {
            await axiosInstance.post(
                API_PREFIX + '/login',
                { login, password },
            );
            user.value = (await axiosInstance.get(API_PREFIX + '/user')).data.data;
            console.log(user.value);
            return true;
        } catch (error) {
            console.log('login failed', error);
            return false;
        }
    }

    async function logout() {
        if (user.value == null) {
            return;
        }

        await axiosInstance.post(API_PREFIX + '/logout');
        user.value = null;
        window.location.reload();
    }

    return {
        user,
        userLoaded,
        attemptLogin,
        logout,
        getData,
        getAllDoctors,
        getDoctor,
        getDoctorAvailableAppointments,
        getDoctorAppointments,
        addDoctorAppointment,
        async cancelAppointment(appointmentId: string) {
            await axiosInstance.delete(API_PREFIX + `/appointments/${appointmentId}`);
        },
        getAllDoctorPatients,
        getPatient,
        postPatientCaseRecord,
        getAllPatientCaseRecords,
        getAllSpecialities,
        getSpeciality,
        getAllNews,
        getAboutText,
        async confirmAppointment(id: string) {
            await axiosInstance.patch(API_PREFIX + `/appointments/${id}/confirm`);
        },
        async getPatientAppointments(patientId: string, date: string): Promise<any[]> {
            return await getData(`/patients/${patientId}/appointments`, { date });
        },
    };
});

import { ref } from 'vue';
import axios, { AxiosError } from 'axios';

export const HOST = import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000';
export const API_PREFIX = '/api';

export class LogInError extends Error {}

export class Api {
    onServerError;
    onUnknownError;
    onConnectionError;
    user = ref(undefined);
    userLoaded;

    #axios;

    constructor(onServerError = null, onUnknownError = null) {
        this.onServerError = onServerError;
        this.onUnknownError = onUnknownError;

        this.#axios = axios.create({
            baseURL: HOST,
            withCredentials: true,
            withXSRFToken: true,
        });

        this.user = ref(undefined);
        this.userLoaded = new Promise((resolve, reject) => {
            this.#get('user', {}, 401).then((result) => {
                if (!result) {
                    this.user.value = null;
                    resolve(null);
                }

                this.user.value = result;
                resolve(result);
            });
        });
    }

    /**
     *
     * @param {string} url
     * @param {object} params
     * @returns {Promise<object>}
     */
    async #get(url, params = undefined, expectedErrorStatus = null) {
        try {
            const response = await this.#axios.get(API_PREFIX + '/' + url, { params });
            return response.data.data;
        } catch (error) {
            if (error.response) {
                switch (error.response.status) {
                    case expectedErrorStatus:
                        return null;
                    case 500:
                        this.onServerError && this.onServerError();
                        return null;
                    default:
                        this.onUnknownError && this.onUnknownError();
                        return null;
                }
            } else if (error.request) {
                this.onConnectionError && this.onConnectionError();
                return null;
            } else {
                throw error;
            }
        }
    }

    /**
     *
     * @param {string} url
     * @param {object} data
     * @returns {Promise<object>}
     */
    async #post(url, data = undefined, expectedErrorStatus = null) {
        try {
            const response = await this.#axios.post(API_PREFIX + '/' + url, data);
            return true;
        } catch (error) {
            if (error.response) {
                switch (error.response.status) {
                    case expectedErrorStatus:
                        return null;
                    case 500:
                        this.onServerError && this.onServerError();
                        return null;
                    default:
                        this.onUnknownError && this.onUnknownError();
                        return null;
                }
            } else if (error.request) {
                this.onConnectionError && this.onConnectionError();
                return null;
            } else {
                throw error;
            }
        }
    }

    async #delete(url, data = undefined, expectedErrorStatus = null) {
        try {
            const response = await this.#axios.delete(API_PREFIX + '/' + url, data);
            return true;
        } catch (error) {
            if (error.response) {
                switch (error.response.status) {
                    case expectedErrorStatus:
                        return null;
                    case 500:
                        this.onServerError && this.onServerError();
                        return null;
                    default:
                        this.onUnknownError && this.onUnknownError();
                        return null;
                }
            } else if (error.request) {
                this.onConnectionError && this.onConnectionError();
                return null;
            } else {
                throw error;
            }
        }
    }

    async #patch(url, data = undefined, expectedErrorStatus = null) {
        try {
            const response = await this.#axios.patch(API_PREFIX + '/' + url, data);
            return true;
        } catch (error) {
            if (error.response) {
                switch (error.response.status) {
                    case expectedErrorStatus:
                        return null;
                    case 500:
                        this.onServerError && this.onServerError();
                        return null;
                    default:
                        this.onUnknownError && this.onUnknownError();
                        return null;
                }
            } else if (error.request) {
                this.onConnectionError && this.onConnectionError();
                return null;
            } else {
                throw error;
            }
        }
    }

    /**
     * Fetches a doctor with the given id
     * @param {number} doctorId
     * @returns {Promise<object>}
     */
    async getDoctor(doctorId) {
        return await this.#get(`doctors/${doctorId}`, {}, 404);
    }

    async getDoctors(specialityId = null) {
        return await this.#get('doctors', { specialityId });
    }

    async getDoctorAvailableAppointmentTimes(doctorId, date) {
        return await this.#get(`doctors/${doctorId}/available-appointment-times`, { date });
    }

    async getDoctorAppointments(doctorId, date) {
        return await this.#get(`doctors/${doctorId}/appointments`, { date });
    }

    async addDoctorAppointment(doctorId, dateTime) {
        await this.#post(`doctors/${doctorId}/appointments`, { dateTime });
    }

    async getNews() {
        return await this.#get('news');
    }

    async getSpeciality(id) {
        return await this.#get(`specialities/${id}`, {}, 404);
    }

    async getSpecialities() {
        return await this.#get('specialities');
    }

    async getPatientAppointments(patientId, date) {
        return await this.#get(`patients/${patientId}/appointments`, { date });
    }

    async confirmAppointment(appointmentId) {
        return await this.#patch(`appointments/${appointmentId}/confirm`);
    }

    async logIn(username, password) {
        console.log('Log in attempt...');
        const csrfResponse = await this.#axios.get('sanctum/csrf-cookie');
        console.log('Csrf Response:', csrfResponse);
        let result = await this.#post('auth/log-in', { username, password }, 403);
        if (!result) {
            console.log('Log in failed');
            return false;
        }

        console.log('Successfully logged in');
        this.user.value = await this.#get('user');
        return true;
    }

    async logOut() {
        if (!this.user.value) {
            return;
        }

        await this.#delete('auth/log-out');
        this.user.value = null;
    }

    async getAgoraToken() {
        let response = await this.#axios.get('agora/token');
        return response.data;
    }

    async join() {}
}

// /**
//  * Fetches the doctor's appointments for the queried date
//  * @param {number} doctorId
//  * @param {*} date
//  * @returns {Promise<object>}
//  */
// export async function getDoctorAppointments(doctorId, date) {
//     return await getData(`/doctors/${doctorId}/appointments`, {
//         date: date.toISOString(),
//     });
// }

// export async function getDoctorAvailableAppointments(doctorId, date) {
//     try {
//         const response = await axiosInstance.get(
//             API_PREFIX + `/doctors/${doctorId}/available-appointments`,
//             {
//                 params: {
//                     date: date.toISOString(),
//                 },
//             },
//         );
//         return response.data.data;
//     } catch (error) {
//         if (error.response && error.response.status == 404) {
//             return null;
//         } else {
//             throw error;
//         }
//     }
// }

// export async function addDoctorAppointment(doctorId, datetime) {
//     await axiosInstance.post(API_PREFIX + `/doctors/${doctorId}/appointments`, {
//         datetime,
//     });
// }

// export async function getAllDoctorPatients() {
//     return getData(`/doctors/${user.value.doctor.id}/patients`);
// }

// export async function getPatient(patientId) {
//     try {
//         return await getData(`/patients/${patientId}`);
//     } catch (error) {
//         if (error.response && error.response.status == 404) {
//             return null;
//         } else {
//             throw error;
//         }
//     }
// }

// export async function getAllPatientCaseRecords(patientId) {
//     try {
//         return await getData(`/patients/${patientId}/case-records`);
//     } catch (error) {
//         if (error.response && error.response.status == 404) {
//             return null;
//         } else {
//             throw error;
//         }
//     }
// }

// export async function postPatientCaseRecord(patientId, caseRecordText) {
//     console.log(patientId, caseRecordText);
//     const response = await axiosInstance.post(API_PREFIX + `/patients/${patientId}/case-records`, {
//         text: caseRecordText,
//     });
//     console.log(response);
// }

// export async function getSpeciality(specialityId) {
//     try {
//         return await getData(`/specialities/${specialityId}`);
//     } catch (error) {
//         if (error.response && error.response.status == 404) {
//             return null;
//         } else {
//             throw error;
//         }
//     }
// }

// export async function getAllNews() {
//     const response = await axiosInstance.get(API_PREFIX + '/news');
//     return response.data.data;
// }

// export async function getAboutText() {
//     const response = await axiosInstance.get(API_PREFIX + '/about');
//     return response.data.data;
// }

// export async function attemptLogin(login, password) {
//     console.log('Log-in attempt...');
//     const csrfResponse = await axiosInstance.get('/sanctum/csrf-cookie');
//     console.log('Csrf Response:', csrfResponse);
//     try {
//         await axiosInstance.post(API_PREFIX + '/login', { login, password });
//     } catch (error) {
//         console.log('login failed', error);
//         return false;
//     }
//     user.value = (await axiosInstance.get(API_PREFIX + '/user')).data.data;
//     console.log(user.value);
//     return true;
// }

// export async function logout() {
//     if (user.value == null) {
//         return;
//     }

//     await axiosInstance.post(API_PREFIX + '/logout');
//     user.value = null;
//     window.location.reload();
// }

// export async function cancelAppointment(appointmentId) {
//     await axiosInstance.delete(API_PREFIX + `/appointments/${appointmentId}`);
// }

// export async function confirmAppointment(id) {
//     await axiosInstance.patch(API_PREFIX + `/appointments/${id}/confirm`);
// }

// export async function getPatientAppointments(patientId, date) {
//     return await getData(`/patients/${patientId}/appointments`, { date });
// }

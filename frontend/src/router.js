import { createRouter, createWebHistory } from 'vue-router';

// import {  } from '@/stores/api';

import HomeView from '@/views/HomeView.vue';
import DoctorsView from '@/views/DoctorsView.vue';
// import MyPatientsView from '@/views/MyPatientsView.vue';
// import PatientCaseRecords from '@/views/PatientCaseRecords.vue';
// import DoctorAppointments from '@/views/DoctorAppointments.vue';


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/doctors',
            name: 'doctors',
            component: DoctorsView,
        },
        {
            path: '/doctors/:doctorId/appointments',
            name: 'doctor-appointments',
            component: () => import('@/views/DoctorAppointments.vue'),
            meta: {
                allowedRoles: ['patient'],
            },
        },
        // {
        //     path: '/my-appointments',
        //     name: 'my-appointments',
        //     component: () => import('@/views/DoctorMyAppointments.vue'),
        //     meta: {
        //         allowedRoles: ['doctor'],
        //     },
        // },
        {
            path: '/patient/appointments',
            name: 'patient-appointments',
            component: () => import('@/views/PatientMyAppointments.vue'),
            meta: {
                allowedRoles: ['patient'],
            },
        },
        {
            path: '/specialities',
            name: 'specialities',
            component: () => import('@/views/SpecialitiesView.vue'),
        },
        // {
        //     path: '/about',
        //     name: 'about',
        //     // route level code-splitting
        //     // this generates a separate chunk (About.[hash].js) for this route
        //     // which is lazy-loaded when the route is visited.
        //     component: () => import('@/views/AboutView.vue'),
        // },

        {
            path: '/me',
            name: 'my-profile',
            component: () => import('@/views/MyProfile.vue'),
            meta: {
                allowedRoles: ['patient', 'doctor', 'nurse'],
            },
        },
        // {
        //     path: '/patients',
        //     name: 'my-patients',
        //     component: MyPatientsView,
        //     meta: {
        //         allowedRoles: ['doctor'],
        //     },
        // },
        // {
        //     path: '/patients/:patientId/case-records',
        //     name: 'case-records',
        //     component: PatientCaseRecords,
        //     meta: {
        //         allowedRoles: ['doctor'],
        //     },
        // },
    ],
});

export default router;

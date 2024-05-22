import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('@/views/HomeView.vue'),
        },
        {
            path: '/doctors',
            name: 'doctors',
            component: () => import('@/views/IndexDoctorsView.vue'),
        },
        {
            path: '/doctors/:id',
            name: 'show-doctor',
            component: () => import('@/views/ShowDoctorView.vue'),
        },
        {
            path: '/doctors/:doctorId/video',
            name: 'video-call',
            component: () => import('@/views/VideoCallView.vue'),
            meta: {
                allowedRoles: ['patient', 'doctor'],
            },
        },
        {
            path: '/doctors/:doctorId/appointments',
            name: 'doctor-appointments',
            component: () => import('@/views/DoctorAppointments.vue'),
            meta: {
                allowedRoles: ['patient'],
            },
        },
        {
            path: '/my-appointments',
            name: 'my-appointments',
            component: () => import('@/views/DoctorMyAppointments.vue'),
            meta: {
                allowedRoles: ['doctor'],
            },
        },
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
            component: () => import('@/views/IndexSpecialitiesView.vue'),
        },
        {
            path: '/about',
            name: 'about',
            component: () => import('@/views/AboutView.vue'),
        },
        {
            path: '/join',
            name: 'join',
            component: () => import('@/views/JoinView.vue'),
        },
        {
            path: '/me',
            name: 'my-profile',
            component: () => import('@/views/MyProfile.vue'),
            meta: {
                allowedRoles: ['patient', 'doctor', 'nurse'],
            },
        },
        {
            path: '/patients',
            name: 'my-patients',
            component: () => import('@/views/DoctorPatientsView.vue'),
            meta: {
                allowedRoles: ['doctor'],
            },
        },
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

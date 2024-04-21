<script setup>
import { onMounted, onErrorCaptured, inject } from 'vue';
import { RouterView, useRouter } from 'vue-router';
import { Modal } from 'bootstrap';

import HeaderElement from '@/components/HeaderElement.vue';
import ErrorModal from '@/components/ErrorModal.vue';

const SERVER_ERROR_MODAL_ID = 'server-error-modal';
const UNKNOWN_ERROR_MODAL_ID = 'unknown-error-modal';
const CONNECTION_ERROR_MODAL_ID = 'connection-error-modal';
const CLIENT_ERROR_MODAL_ID = 'self-error-modal';

let router = useRouter();
let api = inject('api');

let serverErrorModal, unknownErrorModal, connectionErrorModal, clientErrorModal;

onMounted(() => {
    serverErrorModal = new Modal(document.getElementById(SERVER_ERROR_MODAL_ID));
    unknownErrorModal = new Modal(document.getElementById(UNKNOWN_ERROR_MODAL_ID));
    connectionErrorModal = new Modal(document.getElementById(CONNECTION_ERROR_MODAL_ID));
    clientErrorModal = new Modal(document.getElementById(CLIENT_ERROR_MODAL_ID));

    api.onServerError = () => {
        serverErrorModal.show();
    };
    api.onUnknownError = () => {
        unknownErrorModal.show();
    };
    api.onConnectionError = () => {
        connectionErrorModal.show();
    };
});

onErrorCaptured(() => {
    if (!clientErrorModal) {
        return;
    }

    clientErrorModal.show();
});
</script>

<template>
    <div>
        <HeaderElement />
        <main class="container py-4">
            <RouterView />
        </main>
    </div>

    <ErrorModal :id="SERVER_ERROR_MODAL_ID" title="Ошибка сервера!" />
    <ErrorModal :id="UNKNOWN_ERROR_MODAL_ID" title="Неизвестная ошибка!" />
    <ErrorModal :id="CONNECTION_ERROR_MODAL_ID" title="Нет соединения с сервером!" />
    <ErrorModal :id="CLIENT_ERROR_MODAL_ID" title="Ошибка клиента!" />
</template>

<style lang="scss">
$primary: #ff0060;

@import 'bootstrap/scss/bootstrap';

main {
    margin-top: 109px;
}
</style>

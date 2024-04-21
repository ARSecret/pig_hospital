<script setup>
import { useRouter } from 'vue-router';

let router = useRouter();

defineProps(['id', 'title']);
</script>

<template>
    <div
        :id
        class="modal fade"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="staticBackdropLabel" class="modal-title fs-5">{{ title }}</h1>
                </div>
                <div class="modal-body">Попробуйте перезагрузить страницу</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="router.go()">
                        Перезагрузить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

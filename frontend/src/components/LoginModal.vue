<script setup lang="ts">
import * as bootstrap from 'bootstrap';
import { ref } from 'vue';

import { useApi } from '@/stores/api';

let api = useApi();

let props = defineProps<{
    id: string,
}>();

let password = ref('');
let login = ref('');
let loginFailed = ref(false);

async function attemptLogin(event: Event) {
    event.preventDefault();
    let result = await api.attemptLogin(login.value, password.value);
    if (!result) {
        console.log('failed login');
        loginFailed.value = true;
    } else {
        let modalElement = document.getElementById(props.id);
        if (!modalElement) {
            throw new Error('');
        }
        let modal = bootstrap.Modal.getInstance(modalElement);
        modal?.hide();
    }
}
</script>

<template>
    <div class="modal fade" :id="props.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Логин</label>
                            <input type="text" :class="'form-control' + (loginFailed ? ' is-invalid' : '')" id="exampleInputEmail1" aria-describedby="emailHelp"
                                v-model="login">
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">Пароль</label>
                            <input type="password" :class="'form-control' + (loginFailed ? ' is-invalid' : '')" id="exampleInputPassword1" v-model="password">
                            <div class="invalid-feedback">Неверный логин или пароль!</div>
                        </div>

                        <button class="btn btn-primary" @click="attemptLogin">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>

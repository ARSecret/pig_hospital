<script setup>
import { Modal } from 'bootstrap';
import { inject, ref } from 'vue';

let api = inject('api');

let { id } = defineProps(['id']);

let password = ref('');
let login = ref('');
let loginFailed = ref(false);

async function attemptLogin(event) {
    event.preventDefault();
    let result = await api.logIn(login.value, password.value);
    if (!result) {
        console.log('failed login');
        loginFailed.value = true;
        return;
    }

    let modalElement = document.getElementById(id);
    if (!modalElement) {
        throw new Error("Couldn't query log-in modal");
    }
    let modal = Modal.getInstance(modalElement);
    modal?.hide();
}
</script>

<template>
    <div
        :id
        class="modal fade"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Логин</label>
                            <input
                                id="exampleInputEmail1"
                                v-model="login"
                                type="text"
                                :class="'form-control' + (loginFailed ? ' is-invalid' : '')"
                                aria-describedby="emailHelp"
                            />
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">Пароль</label>
                            <input
                                id="exampleInputPassword1"
                                v-model="password"
                                type="password"
                                :class="'form-control' + (loginFailed ? ' is-invalid' : '')"
                            />
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

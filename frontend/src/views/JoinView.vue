<script setup>
import { ref, inject } from 'vue';

let email = ref('');
let firstName = ref('');
let lastName = ref('');
let patronymic = ref('');
let gender = ref('');

let api = inject('api');

function submit() {

}
</script>

<template>
    <h1>Регистрация</h1>
    <form action="" class="border row p-4" @submit.prevent="submit">
        <div class="col-12 mb-4">
            <label for="email" class="form-label">Электронная почта</label>
            <input id="email" v-model="email" type="email" name="" class="form-control" required />
        </div>

        <div class="col-12 row mb-4">
            <div class="col-12 col-md-4">
                <label for="first-name" class="form-label">Имя</label>
                <input
                    id="first-name"
                    v-model="firstName"
                    type="text"
                    name=""
                    class="form-control"
                    required
                />
            </div>
            <div class="col-12 col-md-4">
                <label for="last-name" class="form-label">Фамилия</label>
                <input id="last-name" type="text" name="" class="form-control" required />
            </div>
            <div class="col-12 col-md-4">
                <label for="patronymic" class="form-label">Отчество</label>
                <input id="patronymic" type="text" name="" class="form-control" />
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Пол</div>
                    <div class="row">
                        <div class="col-6 form-check">
                            <label for="male" class="form-check-label">Мужской</label>
                            <input
                                id="male"
                                v-model="gender"
                                type="radio"
                                name="gender"
                                class="form-check-input"
                                value="male"
                                checked
                            />
                        </div>
                        <div class="col-6 form-check">
                            <label for="female" class="form-check-label">Женский</label>
                            <input
                                id="female"
                                v-model="gender"
                                type="radio"
                                name="gender"
                                class="form-check-input"
                                value="female"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="Зарегистрироваться" class="btn btn-primary" />
        </div>
    </form>
</template>

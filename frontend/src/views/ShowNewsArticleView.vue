<script setup>
import { useRouter, useRoute } from 'vue-router';
import { ref, inject } from 'vue';

let api = inject('api');
let route = useRoute();

let article = ref(undefined);

let newsId = route.params.articleId;
api.getNewsArticle(newsId).then((result) => {
    article.value = result;
});
</script>

<template>
    <div v-if="article">
        <h1>{{ article.title }}</h1>
        <p class="text-body-secondary">{{ article.date }}</p>
        <div class="row">
            <div class="col-12 col-lg-6">
                <img class="img-fluid" :src="article.image_url" alt="">
            </div>
            <div class="col-12 col-lg-6">
                <p>
                    {{ article.text }}
                </p>
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>

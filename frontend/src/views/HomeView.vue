<script setup>
import { ref, inject } from 'vue';

let api = inject('api');

let news = ref(null);

api.getNews().then((result) => {
    news.value = result;
});

function getNewsDateString(newsItem) {
    let date = new Date(newsItem.date);
    let day = date.getDate();
    let dayString = day.toString();
    if (day < 10) {
        dayString = '0' + dayString;
    }

    let month = date.getMonth();
    let monthString = month.toString();
    if (month < 10) {
        monthString = '0' + monthString;
    }

    return `${dayString}.${monthString}.${date.getFullYear()}`;
}
</script>

<template>
    <div v-if="!news">
        <div v-for="i in 8" :key="i" class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img
                        width="640"
                        height="320"
                        class="img-fluid rounded-start placeholder"
                        alt="Placeholder"
                    />
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-8"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-8"></span>
                        </p>
                        <p class="card-text placeholder-glow">
                            <small class="text-body-secondary placeholder col-3"></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-for="newsItem in news" v-else :key="newsItem.id" class="card mb-3 news-card card-image">
        <div class="row g-0">
            <img :src="newsItem.image_url" alt="" class="d-block d-md-none" />
            <div
                class="col-md-5 news-image rounded-start"
                :style="{ 'background-image': `url(${newsItem.image_url})` }"
            ></div>
            <div class="col-md-7">
                <div class="card-body">
                    <p class="card-text text-body-secondary mb-1">
                        {{ getNewsDateString(newsItem) }}
                    </p>
                    <h5 class="card-title">{{ newsItem.title }}</h5>
                    <p class="card-text news-text">
                        {{ newsItem.text }}
                        <div class="news-shadow"></div>
                    </p>
                    <RouterLink :to="{name: 'show-news-article', params: {articleId: newsItem.id}}" class="stretched-link">Читать далее...</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.news-image {
    background-size: cover;
    background-position: center;
}
.news-text {
    position: relative;
    height: 15vw;
    overflow: hidden;
}
.news-shadow {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 30px;
    box-shadow: inset 0 -30px 30px white;
}
</style>

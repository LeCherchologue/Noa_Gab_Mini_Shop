<template>
    <ion-page>
            <div class="container d-flex justify-content-between align-items-center bg-primary text-light">
                <button type="button" class="btn" @click.prevent="this.$router.go(-1)">
                    <i class="fa-solid fa-arrow-left" style="color: #fff; font-size: 1.4rem;"></i>
                </button>
                <div class="text-white">
                    <slot name="page_title"></slot>
                </div>
            </div>
        <ion-content>
            <div class="container pt-3">
                <slot name="content"></slot>
            </div>
        </ion-content>
    </ion-page>
</template>
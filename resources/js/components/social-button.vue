<script setup lang="ts">

import { usePage } from '@inertiajs/vue3';
import { inject } from 'vue';
const { props } = usePage()
var route = (props.route as any)
let social_button_tab_class = inject("social_button_tab_class")
const attrprops = defineProps({
    imgsrc: String,
    href: String,
    socialname: String
})
</script>
<template>
    <a :href="href" :class="social_button_tab_class">
        <img class="size-[20px] m-3 object-cover" :src="imgsrc" :title="socialname" :alt="socialname"><p class="bold"> {{ socialname }}</p>
    </a>
</template>


<style scoped></style>
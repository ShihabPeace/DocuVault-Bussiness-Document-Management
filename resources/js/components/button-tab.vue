<script setup lang="ts">

import { usePage } from '@inertiajs/vue3';
import { inject } from 'vue';
const { props } = usePage()
var route = (props.route as any)
let button_tab_class = inject("button-tab-class")
const attrprops = defineProps({
    imgsrc: String,
    href: String
})
</script>
<template>
    <a :href="href" :class="button_tab_class">
        <slot />
    </a>
</template>


<style scoped></style>
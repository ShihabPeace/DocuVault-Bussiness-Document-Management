<script setup lang="ts">

import { usePage } from '@inertiajs/vue3';
import { inject } from 'vue';
const { props } = usePage()
var route = (props.route as any)
let button_tab_class = inject("button-tab-class")
const attrprops = defineProps({
    type:String,
    errormsg: String,
})
</script>
<template>
    <div v-if="type == 'block'">
    <p class="font-semibold bg-red-800 border rounded p-2 my-2 border-2 border-red-500">
        {{ errormsg }}
    </p>    
    </div>
    <div v-else>
        <p class="font-bold text-red-800  my-2">
        * {{ errormsg }}
    </p>
    </div>
    
</template>


<style scoped></style>
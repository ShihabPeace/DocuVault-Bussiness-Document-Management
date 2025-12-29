<script setup lang="ts">
import { inject } from 'vue';

let labelstyle = inject('labelstyle');

</script>

<template>
    <p :class="labelstyle">Activity Log</p>
    
</template>

 <style scoped>

 </style> 
<script setup lang="ts">
import RecAccDocs from '@/components/widgets/RecAccDocs.vue';
import PendingDocs from '@/components/widgets/PendingDocs.vue';
import ActivityLog from '@/components/widgets/ActivityLog.vue';
import ExpDocs from '@/components/widgets/ExpDocs.vue';
import { provide, ref } from 'vue';
import { Documents } from '@/schema/Documents';


var cls: String = 'container  p-2 border border-white border-5 rounded-xl'
provide('labelstyle', 'text-white text-[0.7em] font-bold')


const  props  = defineProps<{ documents?: Documents[] }>()
// const jsDocument: Documents[] = props.documents ?? [];


provide('documents', props.documents ?? [])
</script>

<template>
    <div
        class="col-start-4 lg:col-start-3 md:col-start-3 row-span-14 col-end-17 container p-2 gap-3 grid  grid-cols-2 grid-rows-2">

        <RecAccDocs :class="cls" />

        <PendingDocs :class="cls" />

        <ActivityLog :class="cls" />

        <ExpDocs :class="cls" />
    </div>
</template>

<style scoped></style>


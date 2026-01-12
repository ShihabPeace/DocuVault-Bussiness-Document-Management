<script setup lang="ts">
import PendingDocs from '@/components/widgets/PendingDocs.vue';
import ActivityLog from '@/components/widgets/ActivityLog.vue';
import ExpiredDocs from '@/components/widgets/ExpiredDocs.vue';
import { provide, ref } from 'vue';
import { Documents,Actions } from '@/dbschema';


var cls: String = 'container  p-2 border border-white border-5 rounded-xl'
provide('labelstyle', 'text-white text-[0.7em] font-bold')


const  props  = defineProps<{ documents?: Documents[],actions?: Actions[] }>()
provide('documents', props.documents ?? [])
provide('actions', props.actions ?? [])
</script>

<template>
    <div class="col-start-4 lg:col-start-3 md:col-start-3 row-span-14 col-end-17 container p-2 gap-3 grid  grid-cols-2 grid-rows-2">
        <ActivityLog class="col-start-1 col-end-2 row-span-2" />
        <PendingDocs class="col-start-2 col-end-4 row-span-1" />
        <ExpiredDocs class="col-start-2 col-end-4 row-span-1" />
    </div>
</template>

<style scoped></style>


<script setup lang="ts">
import MainLayout from '@/layout/MainLayout.vue';
import PendingDocs from '@/components/widgets/PendingDocs.vue';
import ActivityLog from '@/components/widgets/ActivityLog.vue';
import ExpiredDocs from '@/components/widgets/ExpiredDocs.vue';
import QuickStats from '@/components/widgets/QuickStats.vue';
import { provide, ref } from 'vue';
import { Documents,Actions } from '@/dbschema';
import { usePage } from '@inertiajs/vue3';
// const {appname:appName} = usePage().props.value.appName;, appName, appNameAuthUser
// const {auth_userAuthUser} = usePage().props.value.auth_user;
// console.log('Auth User in Dashboard:', AuthUser);
// const page = usePage();
// console.log('Dashboard Loaded',page);
// let auth_user = ref(props.documents);
// console.log('page.auth_user',auth_user);

var cls: String = 'container  p-2 border border-white border-5 rounded-xl'
provide('labelstyle', 'text-white text-[0.7em] font-bold')

let eventColors = { 
  viewed: 'bg-gray-500', 
  pending: 'bg-blue-500', 
  published: 'bg-green-500', 
  deleted: 'bg-red-500', 
  updated: 'bg-yellow-700', 
  expired: 'bg-red-500', 
  canceled: 'bg-yellow-400' 
}
const  props  = defineProps<{ documents?: Documents[],actions?: Actions[], auth_user?: string }>()
console.log('Dashboard Props:', props);
provide('documents', props.documents ?? [])
provide('actions', props.actions ?? [])
provide('eventColors', eventColors)
</script>

<template>
    
        
    <div class="col-start-4 lg:col-start-3 md:col-start-3 row-span-14 col-end-17 container p-2 gap-3 grid  grid-cols-2 grid-rows-2">
        <ActivityLog class="col-start-1 col-end-2 row-span-1" />
        <PendingDocs class="col-start-2 col-end-4 row-span-1" />
        <QuickStats class="col-start-1 col-end-2 row-span-1" />
        <ExpiredDocs class="col-start-2 col-end-4 row-span-1" />

    </div>
    
</template>

<style scoped></style>


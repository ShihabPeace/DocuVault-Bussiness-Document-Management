<script setup lang="ts">
import { computed,onMounted, inject, ref } from 'vue';
import axios from 'axios';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import { Documents } from '@/dbschema';
import listrow from '@/components/listrow.vue';
import { route } from 'ziggy-js';
import { echo }  from '@laravel/echo-vue';

let Recent = ref<Documents[]>([]);
const documents = inject<Documents[]>('documents', []);
let labelstyle = inject('labelstyle');

onMounted(() => {
    if (!echo) return;

    const echoInstance = echo();
    echoInstance.private('admin-notifications').listen('NewElementAdded', (e: any) => {
        Recent.value.unshift(e.document);
        console.log('DocumentPendingEvent received:', e);
        // Optionally update Recent or documents here
    });
});
    
async function cancel(id: number) {
    try {
        let res = await axios.post(route('cancel', { 'penddocid': id }));
    } catch (error: any) {
        if (error.response) {
            console.log(error.response.data.error);
            console.log(error.response.data.errors);
            console.log(error.response.data.message);
        }
        console.log('unknown error');
    }
}
async function approve(id: number) {
    try {
        let res = await axios.post(route('approve', { 'pendocidid': id }));
    } catch (error: any) {
        if (error.response) {
            console.log(error.response.data.error);
            console.log(error.response.data.errors);
            console.log(error.response.data.message);
        }
        console.log('unknown error');
    }
}

</script>

<template>
    <div class="h-full flex flex-col border border-white rounded-md p-2 ">
        <p :class="labelstyle">Pending Documents</p>
        <PerfectScrollbar>
            <listrow>
                <div v-if="Recent.length">
                    <div v-for="penddoc in Recent" :key="penddoc.id">
                        <a v-if="penddoc.status === 'pending'"
                            class="px-3 bg-blue-500 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                            href="#">
                            {{ penddoc.filename }} <br>
                            at {{ penddoc.expire_date }}
                            <div class="w-[17%]  m-1 sm:w-[9%] md:w-[8%] lg:w-[6%] xl:w-[4%]">
                                <img @click="cancel(penddoc.id)" src="images/mark.png"
                                    class="size-full m-1 object-cover">
                                <img @click="approve(penddoc.id)" src="images/bin.png"
                                    class="size-full m-1 border rounded border-red-500 bg-red-500 object-cover">
                            </div>
                            <div
                                class="right-[5px] top-[5px] size-[6px] rounded-xl absolute border-1 border-white  bg-red-500">
                            </div>
                        </a>
                    </div>
                </div>

                <div v-if="documents">
                    <div v-for="penddoc in documents" :key="penddoc.id">
                        <a v-if="penddoc.status === 'pending'"
                            class="px-3 bg-blue-500 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                            href="#">
                            {{ penddoc.filename }} <br>
                            at {{ penddoc.expire_date }}
                            <div class="w-[17%]  m-1 sm:w-[9%] md:w-[8%] lg:w-[6%] xl:w-[4%]">
                                <img @click="cancel(penddoc.id)" src="images/mark.png"
                                    class="size-full m-1 object-cover">
                                <img @click="approve(penddoc.id)" src="images/bin.png"
                                    class="size-full m-1 border rounded border-red-500 bg-red-500 object-cover">
                            </div>
                            
                        </a>
                    </div>
                </div>
                <div v-else>
                    <p :class="labelstyle">No Pending Documents</p>
                </div>
            </listrow>
        </PerfectScrollbar>
    </div>

</template>

<style scoped></style>
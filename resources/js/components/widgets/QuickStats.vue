<script setup lang="ts">
import { computed,onMounted, inject, ref } from 'vue';
import axios from 'axios';
import { Documents, Actions, Users } from '@/dbschema';
import listrow from '../listrow.vue';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import { route } from 'ziggy-js';
let labelstyle = inject('labelstyle');
import { echo } from '@laravel/echo-vue';

let Recent = ref<Documents[]>([]);
const documents = inject<Documents[]>('documents', []);

onMounted(() => {
    if (!echo) return;

    const echoInstance = echo();
    echoInstance.private('admin-notifications').listen('NewElementAdded', (e: any) => {
        Recent.value.unshift(e.document);
        console.log('DocumentPendingEvent received:', e);
        // Optionally update Recent or documents here
    });
});

let PdD = computed(() => documents.filter(d => d.status === 'pending'))
let ED = computed(() => documents.filter(d => d.status === 'expired'))
let PD = computed(() => documents.filter(d => d.status === 'published'))
let CD = computed(() => documents.filter(d => d.status === 'canceled'))
let DD = computed(() => documents.filter(d => d.status === 'deleted'))

let PendingDocs = computed(() => PdD.value.sort(datesort));
let ExpiredDocs = computed(() => ED.value.sort(datesort));
let PublishedDocs = computed(() => PD.value.sort(datesort));
let CanceledDocs = computed(() => CD.value.sort(datesort));
let DeletedDocs = computed(() => DD.value.sort(datesort));

const eventColors = inject<Record<string, string>>('eventColors', {});


function getclrcls(evnt_type: string) {
    return eventColors[evnt_type] || 'bg-gray-500';
}

const date = new Date()

function datesort(a: Documents, b: Documents) {
    let dateA = new Date(a.created_at);
    let dateB = new Date(b.created_at);
    return dateB.getTime() - dateA.getTime();
}

function addOne(num: number) {
    switch (true) {
        case true:
            return num + 1;
    }
}

function getAmPm(hour: number) {
    switch (true) {
        case hour >= 12:
            return "PM";
        case hour < 12:
            return "AM";
        default:
            return "";
    }
}

function formatTwoDigits(num: number) {
    switch (true) {
        case num < 10:
            return "0" + num;
        default:
            return "" + num;
    }
}

function toNumber(d1: any): Array<number> {
    const bd: Array<number> = [];
    for (let i = 0; i < d1.length; i++) {
        bd[i] = Number(d1[i]);
    }
    return bd;
}

function dateparser(d: string) {

    const now = new Date()
    let phptojsdatearr = d.split(' ')
    let date = toNumber(phptojsdatearr[0].split('-'))
    let time = toNumber(phptojsdatearr[1].split(':'))
    let phpdate = new Date(date[0], date[1], date[2], time[0], time[1])
    if (phpdate > now) {
        return true
    }
    return false
}

console.log(documents);
</script>

<template>
    <div class="h-full flex flex-col border border-white rounded-md p-2 ">

        <p :class="labelstyle">QuickStats</p>
        <!-- <PerfectScrollbar>
            {{ PD.length }} Published Documents <br>
            {{ PdD.length }} Pending Documents <br>
            {{ ED.length }} Expired Documents <br>
            {{ CD.length }} Canceled Documents <br>
            {{ DD.length }} Deleted Documents <br>
            <div v-for="doc in PendingDocs" :key="doc.id">
                <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                    href="#">
                    {{ doc.filename }} {{ doc.status }} <br>
                    at {{ doc.created_at }}
                    <div class="right-[5px] top-[5px] size-[6px] rounded-xl absolute border-1 border-white ">
                    </div>
                </a>
            </div>

        </PerfectScrollbar> -->
        <PerfectScrollbar>
            <listrow>
                <div v-if="Recent.length">
                    <!-- Pending Documents -->
                    <div v-if="PendingDocs.length">
                        <p class="text-white">Pending Documents:</p>
                        <div v-for="doc in PendingDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Expired Documents -->
                    <div v-if="ExpiredDocs.length">
                        <p class="text-white">Expired Documents:</p>
                        <div v-for="doc in ExpiredDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Published Documents -->
                    <div v-if="PublishedDocs.length">
                        <p class="text-white">Published Documents:</p>
                        <div v-for="doc in PublishedDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Canceled Documents -->
                    <div v-if="CanceledDocs.length">
                        <p class="text-white">Canceled Documents:</p>
                        <div v-for="doc in CanceledDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Deleted Documents -->
                    <div v-if="DeletedDocs.length">
                        <p class="text-white">Deleted Documents:</p>
                        <div v-for="doc in DeletedDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-white border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>                    
                </div>

                <div v-if="documents.length">
                    <!-- Pending Documents -->
                    <div v-if="PendingDocs.length">
                        <p class="text-white">Pending Documents:</p>
                        <div v-for="doc in PendingDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Expired Documents -->
                    <div v-if="ExpiredDocs.length">
                        <p class="text-white">Expired Documents:</p>
                        <div v-for="doc in ExpiredDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Published Documents -->
                    <div v-if="PublishedDocs.length">
                        <p class="text-white">Published Documents:</p>
                        <div v-for="doc in PublishedDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Canceled Documents -->
                    <div v-if="CanceledDocs.length">
                        <p class="text-white">Canceled Documents:</p>
                        <div v-for="doc in CanceledDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>

                    <!-- Deleted Documents -->
                    <div v-if="DeletedDocs.length">
                        <p class="text-white">Deleted Documents:</p>
                        <div v-for="doc in DeletedDocs" :key="doc.id">
                            <a :class="getclrcls(doc.status)" class="px-3 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-white border block rounded-md relative"
                                href="#">
                                {{ doc.filename }} -> {{ doc.status }} <br>
                                at {{ doc.created_at }}
                            </a>
                        </div>
                    </div>


                </div>
                <div v-else>
                    <p :class="labelstyle">No Expired Documents</p>
                </div>
            </listrow>
        </PerfectScrollbar>
    </div>
</template>

<style scoped></style>
<script setup lang="ts">
import { computed, inject, ref } from 'vue';
import axios from 'axios';
import { Documents, Actions, Users } from '@/dbschema';
import listrow from '../listrow.vue';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import { route } from 'ziggy-js';
let labelstyle = inject('labelstyle');

let Recent = ref<Documents[]>([]);
const documents = inject<Documents[]>('documents', []);

const date = new Date()

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
// const fphpdate =
//     phpdate.getFullYear() + '-' +
//     formatTwoDigits(phpdate.getMonth() + 1) + '-' +
//     formatTwoDigits(phpdate.getDate()) + ' ' +
//     formatTwoDigits(phpdate.getHours()) + ':' +
//     formatTwoDigits(phpdate.getMinutes()) + ' ' + getAmPm(phpdate.getHours());
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

async function remove(id: number) {
    try {
        let res = await axios.post(route('remove'), { 'expdocid': id })
        let docelem = documents.findIndex(doc=> doc.id = id)
        if(docelem > -1){
            documents.splice(docelem, 1);
        }
        console.log(id)
        console.log(res.data);
    }
    catch (error: any) {
        if (error.response) {
            console.log(error.response.data.errors);
            console.log(error.response.data.error);
            console.log(error.response.data.message);
        }else{
            console.log('unepected error');
        }
    }
}
console.log(documents);
</script>

<template>
    <div class="h-full flex flex-col border border-white rounded-md p-2 ">

        <p :class="labelstyle">Expired Documents</p>
        <PerfectScrollbar>
            <listrow>
                <div v-if="documents">
                    <div v-for="expdoc in documents" :key="expdoc.id">
                        <a v-if="dateparser(expdoc.expire_date)"
                            class="px-3 bg-red-500 text-[0.5em] flex items-center justify-between sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border block rounded-md relative"
                            href="#">
                            {{ expdoc.filename }} <br>
                            at {{ expdoc.expire_date }}
                            <div @click="remove(expdoc.id)" class="w-[17%] m-3 sm:w-[9%] md:w-[8%] lg:w-[6%] xl:w-[4%]">
                                <img src="images/bin.png" class="size-full object-cover">
                            </div>
                        </a>
                    </div>
                </div>
            </listrow>
        </PerfectScrollbar>
    </div>
</template>

<style scoped></style>
<script setup lang="ts">
import { Actions } from '@/dbschema';
import { echo } from '@laravel/echo-vue';
import axios from 'axios';
import { inject, onMounted, ref } from 'vue';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';
import { route } from 'ziggy-js';
import listrow from '../listrow.vue';
onMounted(() => {
    if (!echo) return;

    const echoInstance = echo();
    echoInstance.private('admin-notifications').listen('NewElementAdded', (e: any) => {
        Recent.value.unshift(e.document);
        console.log('DocumentPendingEvent received:', e);
        // Optionally update Recent or documents here
    });
});
let labelstyle = inject('labelstyle');

let Recent = ref<Actions[]>([]);
const actions = inject<Actions[]>('actions', []);
const eventColors = inject<Record<string, string>>('eventColors', {});

function getclrcls(evnt_type: string) {
    return eventColors[evnt_type] || 'bg-gray-500';
}

async function dbuncheck(actid: number) {
    try {
        const res = await axios.post(route('checked'), { actid: actid });

        console.log('dbuncheck response:', res.data);
        return res; // return it for awaiting
    } catch (error: any) {
        if (error.response) {
            console.log('validation errors:', error.response.data.errors);
            console.log('Controller error message:', error.response.data.error);
            console.log('Message:', error.response.data.message);
        } else {
            console.log('Unexpected error:', error.message);
        }
        throw error; // rethrow if you want to handle it in uncheck
    }
}

async function uncheck(id: number) {
    let trgtelmt = actions.find((act) => act.id === id);

    if (!trgtelmt) return; // safety check

    if (trgtelmt) {
        trgtelmt.checked = 1; // update local state
        console.log('trgtelmt.checked->', trgtelmt.checked, 'trgtelmt->', trgtelmt, 'actid->', id, 'dashboard->', route('checked'));
        try {
            const res = await dbuncheck(id);
            console.log('dbuncheck response:', res?.data);
        } catch (e) {
            console.error('dbuncheck failed', e);
        }
    }
}

let listrowstyle = 'flex flex-col gap-1';
</script>

<template>
    <div class="flex h-full flex-col rounded-md border border-white p-2">
        <p :class="labelstyle">Activity Log</p>
        <!--  -->
        <!-- Scrollable container :href="act.link"-->
        <PerfectScrollbar class="mt-2 flex-1">
            <listrow class="flex flex-col gap-1">
                <div v-if="Recent.length">
                    <div id="unseen" v-for="act in Recent" :key="act.id">
                        <a
                            href="#"
                            @click="uncheck(act.id)"
                            class="relative block rounded-md border px-3 py-1 text-[0.5em] font-bold text-black sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em]"
                            :class="getclrcls(act.event_type)"
                        >
                            {{ act.filename }} was {{ act.event_type }} by {{ act.user.name }} ({{ act.user.role }})
                            <br />
                            {{ act.created_at }}
                            <div class="absolute top-[5px] right-[5px] size-[6px] rounded-xl border-1 border-white bg-red-500"></div>
                        </a>
                    </div>
                </div>
                <div v-if="actions.length">
                    <div id="unseen" v-for="act in actions" :key="act.id">
                        <div v-if="act.checked === 0">
                            <a
                                href="#"
                                @click="uncheck(act.id)"
                                class="relative block rounded-md border px-3 py-1 text-[0.5em] font-bold text-black sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em]"
                                :class="getclrcls(act.event_type)"
                            >
                                {{ act.filename }} was {{ act.event_type }} by {{ act.user.name }} ({{ act.user.role }})
                                <br />
                                {{ act.created_at }}
                                <div class="absolute top-[5px] right-[5px] size-[6px] rounded-xl border-1 border-white bg-red-500"></div>
                            </a>
                        </div>
                        <div v-else></div>
                    </div>
                    <div id="seen" v-for="act in actions" :key="act.id">
                        <div v-if="actions.length">
                            <div v-if="act.checked === 1">
                                <a
                                    href="#"
                                    @click="uncheck(act.id)"
                                    class="relative block rounded-md border px-3 py-1 text-[0.5em] font-bold text-black sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em]"
                                    :class="getclrcls(act.event_type)"
                                >
                                    {{ act.filename }} was {{ act.event_type }} by {{ act.user.name }} ({{ act.user.role }})
                                    <br />
                                    {{ act.created_at }}
                                </a>
                            </div>
                            <div v-else></div>
                        </div>
                        <div v-else>
                            <p class="text-white">No activities found.</p>
                        </div>
                    </div>
                </div>
            </listrow>
        </PerfectScrollbar>
    </div>
</template>

<style scoped></style>
<!-- @click.prevent="uncheck(act.id)" -->

<script setup lang="ts">
import { inject } from 'vue';
import { ref, computed, reactive } from 'vue';
import axios from 'axios';
import listrow from '../listrow.vue';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/style.css'
import ActivityLog from './ActivityLog.vue';
import { Documents,Actions,Users } from '@/Documents';

let labelstyle = inject('labelstyle');

// const props = defineProps<{ activity?: ModelActivity[] }>();

// Ensure props.activity is always an array
// const jsActivity: ModelActivity[] = props.activity ?? [];

// Make Recent reactive and safe (empty array initially)
// let Recent = ref<ModelActivity[]>([
//     {
//         id: 1,
//         indicolor: 'bg-green-500',
//         content: 'New Document Created',
//         user: 'John Doe',
//         link: '#',
//         role: 'Admin',
//         date: new Date(),
//         checked: false
//     },
//     {
//         id: 2,
//         indicolor: 'bg-red-500',
//         content: 'Document Deleted',
//         user: 'Jane Smith',
//         link: '#',
//         role: 'User',
//         date: new Date(),
//         checked: true
//     },
//     {
//         id: 3,
//         indicolor: 'bg-blue-500',
//         content: 'Document Updated',
//         user: 'Alice Johnson',
//         link: '#',
//         role: 'Editor',
//         date: new Date(),
//         checked: false
//     }
// ]);

// let seen = props.props.activity.filter(item => item.checked === true)
// let unseen = props.props.activity.filter(item => item.checked === false)
// let unseen = computed(()=>(props.activity?.filter(item => item.checked === false)) || [])
// let seen = computed(()=>(props.activity.filter(item => item.checked === true)))
let Recent = ref<Documents[]>([]);
const documents = inject<Documents[]>('documents',[]);

const allActivities = computed(()=> [...documents, ...Recent.value]) ;
const unseen = computed(() => allActivities.value.filter(item => !item.checked));
const seen = computed(() => allActivities.value.filter(item => item.checked));

console.log('unseen',unseen.value);
console.log('seen',seen.value);

function getclrcls(item:Documents){
    switch(item.status){
        case 'PENDING':
            return 'bg-yellow-500';
        case 'PUBLISHED':
            return 'bg-blue-500';
        case 'CANCELLED':
            return 'bg-red-500';
        case 'EXPIRED':
            return 'bg-gray-500';
        default:
            return 'bg-green-500';
    }
}

// function uncheck(item)
//    item.checked != item.checked
// }

let listrowstyle = 'flex flex-col gap-1'
</script>

<template>
    <div class="h-full flex flex-col border border-white rounded-md p-2 ">
        <p :class="labelstyle">Recent Activity</p>
        <div v-for="item in unseen" :key="item.id">
  <p class="text-white">
    {{ item.content }} is
    <span v-for="(act, index) in item.action" :key="index">
      {{ act.action }} by {{ act.user?.name }} ({{ act.user?.role }})
    </span>
  </p>
</div>

        
        <!-- Scrollable container -->
        <!-- <PerfectScrollbar class="flex-1 mt-2">
            <listrow class="flex flex-col gap-1">
                <div v-if="unseen.length || seen.length">
                <div  id="unseen" v-for="item in unseen" :key="item.id"
                    class="px-3 text-[0.5em] sm:text-[0.6em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border rounded-md relative"
                    :class="getclrcls">
                        
                    <a :href="item.link">{{ item.id }}. {{ item.content }} <br> by {{ item.user
                    }}({{ item.role }}) 
                        <br>
                        {{ item.created_at }}</a>
                    <div class="right-[5px] top-[5px] size-[6px] rounded-xl absolute border-1 border-white  bg-red-500">
                    </div>

                </div>

                <div id="seen" v-for="item in seen" :key="item.id"
                    class="px-3 text-[0.4em] sm:text-[0.5em] md:text-[0.6em] lg:text-[0.65em] xl:text-[0.7em] font-bold py-1 text-black border rounded-md relative"
                    :class="item.indicolor">

                    <a :href="item.link">{{ item.id }}. {{ item.content }} <br> by {{ item.user
                    }}({{ item.role }})
                        <br>
                        {{ item.created_at }} </a>
                </div>
                </div>
                <div v-else>
                    <p class="text-white">No activities found.</p>
                </div>
            </listrow>
        </PerfectScrollbar> -->
    </div>
</template>

<style scoped></style>
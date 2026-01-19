<script setup lang="ts">
import { onBeforeMount, ref } from 'vue';
import { inject } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SearchBar from './search-bar.vue'
import Tab from './tab.vue';
import Logo from './logo.vue';
import notification from './notification.vue';
import { AuthData } from '@/dbschema';
import ButtonTab from './button-tab.vue';
import { route } from 'ziggy-js';

// onBeforeMount(() => {
// })
const authData = inject<AuthData >('authData',{auth_user:false});  

</script>
<!-- navbar: -->
<template>
    <div class="p-4 xl:p-5 lg:p-3 p-2 xl:p-3 col-start-1 col-end-17 justify-between border-white w-full flex flex-row">
        <Logo title="DocuVault"/>
        
        <div class="transition-all md:justify-end justify-between sm:w-[30%] md:w-[40%]  items-center flex">
            <notification v-show="authData.auth_user" title="Notifications" imgsrc="images/notify.png"/>
            <Tab v-show="authData.auth_user" title="Upload" imgsrc="images/upload.png"/>            
            <Tab v-show="authData.auth_user" title="Profile" imgsrc="images/user.png" />
            <div class="flex">
                <ButtonTab :href="route('login')" v-show="!authData.auth_user" title="login">
                    Log-in
                </ButtonTab>
                <ButtonTab :href="route('signup')" v-show="!authData.auth_user" title="signup" >
                    Sign-up
                </ButtonTab>
            </div>

        </div>
        <SearchBar v-show="authData.auth_user" title="Search"/>
    </div>

</template>

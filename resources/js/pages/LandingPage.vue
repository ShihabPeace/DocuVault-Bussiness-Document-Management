<script setup lang="ts">
import TopNavbar from '@/components/TopNavbar.vue';
import logo from '@/components/logo.vue';
import { AuthData } from '@/dbschema';
import { inject } from 'vue';

const authData = inject<AuthData>('authData', { auth_user: false });
</script>
<template>
    <TopNavbar />
    <div class=""></div>
    <section class="dark:bg-dark bg-black py-[30px] rounded-xl m-2 w-fulltext-white">
        <div class="mx-auto px-4 sm:container">
            <div class="border-stroke dark:border-dark-3 flex items-center pb-6">
                <div class="mr-[18px] w-full max-w-[60%] overflow-hidden rounded-xl">
                    <logo class="h-25 w-85 border-[10px] text-[3.5em]" />
                </div>
                <div>
                    <h4 class="text-dark mb-1 text-sm text-[2.5em] font-semibold dark:text-white">
                        <p class="flex text-[0.8em] justify-center">Join</p>
                        <span class="flex text-[0.8em]">DocuVault! <p>🎉</p></span>
                    </h4>
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped></style>

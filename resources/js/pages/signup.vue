<script setup lang="ts">
import errorMessage from '@/components/errorMessage.vue';
import Logo from '@/components/logo.vue';
import SocialButton from '@/components/social-button.vue';
import axios from 'axios';
import { ref } from 'vue';
import { route } from 'ziggy-js';
import { router } from '@inertiajs/vue3'



const buttonsize = 'w-[4em]';
let firstName = ref<string>();
let lastName = ref<string>();
let phone = ref<string>();
let email = ref<string>();
let password = ref<string>();
let mainError = ref<string>();
let emailError = ref<string>();
let passwordError = ref<string>();
let phoneError = ref<string>();
let firstNameError = ref<string>();
let lastNameError = ref<string>();
function attempt_auth() {
    try {
        router.post(route('auth_register'), {
            firstName: firstName.value,
            lastName: lastName.value,
            email: email.value,
            password: password.value,
            phone: phone.value,
        });
    } catch (e: any | unknown) {
        console.log(e);

        if (e.response.status == 422) {
            emailError.value = e.response.data?.email?.[0] ?? '';
            passwordError.value = e.response.data?.password?.[0] ?? '';
            mainError.value = e.response.data?.message ?? '';
            console.log(emailError, passwordError);

            console.log('422 error');
        } else if (e.response.status == 400) {
            mainError.value = e.response.data.message;
            console.log('400 error');
        } else if (e.response.status == 401) {
            mainError.value = e.response.data.message;
            console.log('401 error');
        } else if (e.response.status == 403) {
            mainError.value = e.response.data.message;
            console.log('403 error');
        } else {
            mainError.value = 'unknown error';
        }
    }
}
</script>
<template>
    <div class="flex h-dvh min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="rounded-md border border-stone-400 bg-stone-900 p-4">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <Logo class="mx-auto h-10 w-32" alt="DocuVault" title="DocuVault" />
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="">
                    <errorMessage v-show="mainError" type="block" :errormsg="mainError" />
                    <div>
                        <label for="firstName" class="block text-sm/6 font-medium text-gray-100">First Name</label>
                        <div class="mt-2">
                            <input
                                v-model="firstName"
                                type="text"
                                name="firstName"
                                id="firstName"
                                autocomplete="given-name"
                                required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            />
                            <errorMessage v-show="firstNameError" :errormsg="firstNameError" />
                        </div>
                    </div>

                    <div>
                        <label for="lastName" class="block text-sm/6 font-medium text-gray-100">Last Name</label>
                        <div class="mt-2">
                            <input
                                v-model="lastName"
                                type="text"
                                name="lastName"
                                id="lastName"
                                autocomplete="family-name"
                                required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            />
                            <errorMessage v-show="lastNameError" :errormsg="lastNameError" />
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm/6 font-medium text-gray-100">Phone</label>
                        <div class="mt-2">
                            <input
                                v-model="phone"
                                type="tel"
                                name="phone"
                                id="phone"
                                autocomplete="tel"
                                required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            />
                            <errorMessage v-show="phoneError" :errormsg="phoneError" />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-100">Email addes</label>
                        <div class="mt-2">
                            <input
                                v-model="email"
                                type="email"
                                name="email"
                                id="email"
                                autocomplete="email"
                                required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            />
                            <errorMessage v-show="emailError" :errormsg="emailError" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-100">Password</label>
                            <div class="text-sm">
                                <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input
                                v-model="password"
                                type="password"
                                name="password"
                                id="password"
                                autocomplete="current-password"
                                required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            />
                            <errorMessage v-show="passwordError" :errormsg="passwordError" />
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            @click.prevent="attempt_auth"
                            class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                        >
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="m-3 flex items-center justify-between">
                    <p class="h-[0.1em] w-[40%] rounded-xl border bg-white text-white"></p>
                    <p class="w-[20%] text-center text-[0.7em] text-white">OR</p>
                    <p class="h-[0.1em] w-[40%] rounded-xl border bg-white text-white"></p>
                </div>
                <div class="flex">
                    <SocialButton class="border-red-600 bg-red-600" socialname="Google" imgsrc="images/google.png" />
                    <SocialButton id="linkedIn" socialname="linkedIn" imgsrc="images/linkedin.png" />
                </div>

                <p class="mt-10 text-center text-sm/6 text-gray-400">
                    Not a member?
                    {{ ' ' }}
                    <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Start a 14 day free trial</a>
                </p>
            </div>
        </div>
    </div>
</template>
<style scoped>
#linkedIn {
    background-color: #0a66c2;
    border-color: #0a66c2;
}
</style>

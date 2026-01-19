<script setup lang="ts">
import { ref, provide } from "vue";
import TopNavbar from "@/components/TopNavbar.vue";
import LeftSidebar from "@/components/LeftSidebar.vue";
import { AuthData } from "@/dbschema";
provide("tab-class", "transition-all flex xl:size-10 justify-center items-center size-[40px] bg-white rounded-[10px] mx-2 p-2")
provide("button-tab-class", "transition-all flex justify-center items-center h-[40px] w-[80px] bg-white rounded-[10px] mx-2 p-2")
provide("social_button_tab_class", "transition-all flex justify-center items-center h-[40px] w-[16em] border border-2 text-white  rounded-[10px] mx-2 p-2")

const authData = defineProps<{ auth_user: AuthData | boolean}>()
provide("authData", authData);
</script>
<!-- mainlayout -->
<template >
    <div id="container" class="grid  grid-cols-[0.5fr_repeat(15,1fr)] grid-rows-[repeat(15,1fr)]  bg-stone-800 h-dvh">
        <TopNavbar />
        <LeftSidebar />
        <slot />
    </div>
</template>

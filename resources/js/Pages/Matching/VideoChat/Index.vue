<template>
    <app-layout title="대기실">
        <div class="text-center">
            <button @click="connect" class="text-7xl">누구나</button>
            <button @click="connect" class="text-7xl">이성</button>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from "../../../Layouts/AppLayout";
export default defineComponent({
    components: {AppLayout},
    setup() {
        const connect = () => {
            console.log('1')
        };

        return { connect };
    },
})
</script>

<style scoped>

</style>

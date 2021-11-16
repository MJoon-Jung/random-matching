<template>
    <app-layout title="대기실">
        <div class="text-center">
            <button @click="connect" class="text-7xl">매칭</button>
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
            axios.get('/matching/video')

        };

        return { connect };
    },
})
</script>

<style scoped>

</style>

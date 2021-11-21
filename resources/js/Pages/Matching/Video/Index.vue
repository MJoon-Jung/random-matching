<template>
    <app-layout title="대기실">
        <div class="flex-1 flex flex-col">
            <div class="text-center">
                <button @click="blindMatching" class="text-7xl">Blind Matching</button>
            </div>
            <div v-if="loading" class="flex-1 flex justify-center items-center mb-48">
                <svg class="animate-spin h-48 w-48 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {computed, defineComponent, ref} from "vue";
import AppLayout from "../../../Layouts/AppLayout";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
export default defineComponent({
    components: {AppLayout},
    setup() {
        const user = computed(() => usePage().props.value.user)

        const type = ref(null);

        const loading = ref(false);

        const blindMatching = () => {
            type.value = 'blind_video';
            loading.value = true;
            axios.post('/matching/video/connect', { type: type.value })
                .catch((err) => console.error(err));
        };

        window.Echo.private(`users.${user.value.id}`)
            .listen('.new.channel', (event) => {
                console.log(event)
                Inertia.visit(`/video/streaming/${event.channelId}`)
                // window.location.href = `/video/streaming/${event.channelId}`
            })

        return { blindMatching, loading };
    },
})
</script>

<style scoped>

</style>

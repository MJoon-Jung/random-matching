<template>
    <app-layout title="대기실">
        <h1 class="text-7xl text-center">
            랜덤 매칭
        </h1>
        <div class="text-center">
            어떤 매칭을 하실지 정해주세요
        </div>
        <div class="flex-1 flex flex-col">
            <div class="text-center">
                <button @click="blindVideoMatching" class="text-2xl">화상 채팅</button>
            </div>
            <div class="text-center">
                <button @click="blindChatMatching" class="text-2xl">채팅</button>
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
import AppLayout from "../../Layouts/AppLayout";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
export default defineComponent({
    components: {AppLayout},
    setup() {
        const user = computed(() => usePage().props.value.user)

        const loading = ref(false);

        const blindVideoMatching = () => {
            connect('blind_video');
        };
        const blindChatMatching = () => {
            connect('blind_chat');
        };

        const connect = (type) => {
            loading.value = true;
            console.log(type);
            axios.post('/matching/connect', { type: type })
                .catch((err) => console.error(err));
        }

        window.Echo.private(`users.${user.value.id}`)
            .listen('.new.channel', (event) => {
                console.log(event);
                loading.value = false;
                if (event.type === 'blind_video') {
                    Inertia.visit(`/random/video/channel/${event.channelId}`);
                }else {
                    Inertia.visit(`/random/chat/channel/${event.channelId}`);
                }
            })

        return { blindChatMatching, blindVideoMatching, loading };
    },
})
</script>

<style scoped>

</style>

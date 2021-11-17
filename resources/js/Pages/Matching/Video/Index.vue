<template>
    <app-layout title="대기실">
        <div class="text-center">
            <button @click="blindMatching" class="text-7xl">Blind Matching</button>
        </div>
        <div v-if="loading">loading 중</div>
    </app-layout>
</template>

<script>
import {computed, defineComponent, ref} from "vue";
import AppLayout from "../../../Layouts/AppLayout";
import {usePage} from "@inertiajs/inertia-vue3";
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
                console.log(event);
            })

        return { blindMatching, loading };
    },
})
</script>

<style scoped>

</style>

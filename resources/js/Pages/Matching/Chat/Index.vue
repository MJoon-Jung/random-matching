<template>
    <app-layout title="대기실">
        <button @click="matching">아무나</button>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from "../../../Layouts/AppLayout";
export default defineComponent({
    components: {AppLayout},
    setup() {

        const matching = () => {
            axios.get('/matching/chat/connect')
                .then((res) => console.log(res.data))
                .catch((err) => console.error(err));
        }

        return { matching };

    },
})
</script>

<style scoped>

</style>

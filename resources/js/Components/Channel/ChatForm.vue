<template>
    <div>
        <form @submit.prevent="sendChatMessage">
            <input type="text" v-model="message">
            <button type="submit">전송</button>
        </form>
    </div>
</template>

<script>
import {defineComponent, ref} from "vue";

export default defineComponent({
    setup() {
        const message = ref(null);

        const sendChatMessage = () => {
            axios.post(`/channels/1`, { message: message.value })
                .then((res) => console.log(res.data))
                .catch((err) => console.error(err));
        }


        return {message, sendChatMessage};
    }
})
</script>

<style scoped>

</style>

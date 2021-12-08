<template>
    <div>
        <img :src="friend.profile_photo_url" alt="profile">
        <div>{{ friend.email }}</div>
        <div>{{ friend.name }}</div>
        <button @click="handleChat">채팅하기</button>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import {Inertia} from "@inertiajs/inertia";
export default defineComponent({
    props: ['friend'],
    setup(props) {
        const handleChat = () => {
            Inertia.get(`/chat/channels?friend=${props.friend.id}`)
        }

        return { handleChat };
    }
})
</script>

<style scoped>

</style>

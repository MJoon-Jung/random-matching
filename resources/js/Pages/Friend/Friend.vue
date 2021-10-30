<template>
    <app-layout title="Dashboard">
        <div v-for="friend in friends" :key="friend.id">
            <FriendList :friend="friend" />
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from '@/Layouts/AppLayout.vue'
import FriendList from '@/Components/Friend/FriendList';
export default defineComponent({
    components: {
        FriendList,
        AppLayout
    },
    props: ['friends'],
    setup(props) {
        console.log(props.friends);
        return { };
    }
})
</script>

<style scoped>

</style>

<template>
    <app-layout title="Dashboard">
        <Link :href="route('user.notification')" method="get">
            알림
        </Link>
        <div v-for="friend in friends" :key="friend.id">
            <FriendList :friend="friend" />
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from '@/Layouts/AppLayout.vue'
import FriendList from '@/Components/Friend/FriendList';
import {Link} from "@inertiajs/inertia-vue3";
export default defineComponent({
    components: {
        FriendList,
        AppLayout,
        Link
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

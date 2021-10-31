<template>
    <div>
        <img :src="friend.profile_photo_url" alt="profile">
        <div>{{ friend.email }}</div>
        <div>{{ friend.name }}</div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
    props: ['friend'],
    setup(props) {
        return { };
    }
})
</script>

<style scoped>

</style>

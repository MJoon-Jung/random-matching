<template>
    <button @click="$emit('changeCurrentChannel', channel.id)" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" v-for="channel in $page.props.user.channels">
        <div class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">{{ channel.name[0] }}</div>
        <div class="ml-2 text-sm font-semibold">{{ channel.name }}</div>
    </button>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
    props: [],
    setup(){

        return { };
    }
})
</script>

<style scoped>

</style>

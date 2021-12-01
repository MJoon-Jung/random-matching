<template>
    <button @click="$emit('changeCurrentChannel', channel.id)" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" v-for="channel in channels" :key="channel.id">
<!--        <span class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">{{ channel.name[0] }}</span>-->
        <span class="ml-2 text-sm font-semibold">{{ channel.members[0].id !== $page.props.user.id ? channel.members[0].name : channel.members[1].name }}</span>
    </button>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
    props: ['channels'],
    setup(props){

      return { };
    }
})
</script>

<style scoped>

</style>

<template>
    <button v-if="friends" @click="$emit('changeCurrentChannel', friend.id)" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" v-for="friend in friends" :key="friend.id">
<!--        <span class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">{{ friend.name[0] }}</span>-->
        <span class="ml-2 text-sm font-semibold">{{ friend.id !== $page.props.user.id ? friend.name : friend.name }}</span>
    </button>
    <button v-else @click="handleChangeChannel(channel)" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" v-for="channel in channels" :key="channel.id">
<!--        <span class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">{{ friend.name[0] }}</span>-->
        <span class="ml-2 text-sm font-semibold">{{ channel.members[0].id === $page.props.user.id ? channel.members[1].name : channel.members[0].name }}</span>
    </button>
</template>

<script>
import {computed, defineComponent} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
export default defineComponent({
    props: ['friends', 'channels'],
    setup(props, context){
        const user = computed(() => usePage().props.value.user)

        const handleChangeChannel = (channel) => {
            channel.members.forEach((member) => {
                if(member.id !== user.value.id) {
                    context.emit('changeCurrentChannel', channel.id);
                }
            });
        };

      return { handleChangeChannel };
    }
})
</script>

<style scoped>

</style>

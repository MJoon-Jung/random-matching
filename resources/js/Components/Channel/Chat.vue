<template>
    <div v-if="chat.member_id === $page.props.user.id" class="col-start-6 col-end-13 p-3 rounded-lg">
        <div class="flex items-center justify-start flex-row-reverse">
            <img
                :src="chat.member.profile_photo_url"
                alt="Avatar"
                class="h-20 w-20"
            />
            <div
                class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl"
            >
                <div>
                    {{ chat.content }}
                </div>
            </div>
        </div>
    </div>
    <div v-else class="col-start-1 col-end-8 p-3 rounded-lg">
        <div class="flex flex-row items-center">
            <img
                :src="chat.member.profile_photo_url"
                alt="Avatar"
                class="h-20 w-20"
            />
            <div
                class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"
            >
                <div>{{ chat.content }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: ['chat'],
    setup(props) {
        console.log('chat',props.chat);
    },
})
</script>

<style scoped>

</style>

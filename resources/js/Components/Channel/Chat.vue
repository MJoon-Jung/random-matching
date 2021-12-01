<template>
    <div v-if="chat.message.member_id === $page.props.user.id" class="col-start-6 col-end-13 p-3 rounded-lg">
        <div class="flex items-center justify-start flex-row-reverse">
            <img
                :src="chat.message.member.profile_photo_url"
                alt="Avatar"
                class="h-20 w-20"
            />
            <div
                class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl"
            >
                <div>
                    {{ chat.message.content }}
                </div>
            </div>
        </div>
    </div>
    <div v-else class="col-start-1 col-end-8 p-3 rounded-lg">
        <div class="flex flex-row items-center">
            <img
                :src="chat.message.member.profile_photo_url"
                alt="Avatar"
                class="h-20 w-20"
            />
            <div
                class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"
            >
                <div>{{ chat.message.content }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: ['chat'],
    setup(props) {
        // console.log('chat',props.chat);

        /**
         *
         * random chat으로 넘어올 때는 위처럼 chat.message.으로 시작하지만
         * 그냥 chat으로 들어오면 chat.content 이런식으로 바로 쓸 수 있어서
         * 재사용을 하기 위해서는 구조를 바꿀 필요가 있다. 백엔드에서
         *
         */
    },
})
</script>

<style scoped>

</style>

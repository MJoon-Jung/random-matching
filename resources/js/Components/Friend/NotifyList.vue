<template>
    <div class="flex flex-col items-center h-20">
        <div class="w-full flex flex-col items-center">
            <div class="w-full px-4">
                <div class="flex flex-col items-center relative">
                    <div class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                        <div class="flex flex-col w-full">
                            <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100">
                                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                    <div class="w-full items-center flex justify-between">
<!--                                        <img :src="notify.profile_photo_url" alt="profile" />-->
                                        <div class="mx-2 -mt-1">
                                            {{ notify.data.name }}님 에게 친구 요청이 도착했습니다.
                                        </div>
                                        <button @click.prevent="receiveFriend(notity.data.id)" class="text-indigo-500">
                                            친구 수락
                                        </button>
                                        <div class="text-xs mx-2 -mt-1">
                                            {{ relativeCreatedAt(notify.updated_at) }}
                                        </div>
                                        <div class="text-xs mx-2 -mt-1">
                                            {{ notify.read_at ? '읽음' : '안읽음' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import { Link } from '@inertiajs/inertia-vue3';
import relativeTime from 'dayjs/plugin/relativeTime'
import "dayjs/locale/ko";
import dayjs from 'dayjs'
import {Inertia} from "@inertiajs/inertia";
dayjs.extend(relativeTime);
dayjs.locale('ko');
export default defineComponent({
    components: {
        Link,
    },
    props: ['notify'],
    setup(props) {
        console.log(props.notify)
        const relativeCreatedAt = (createdAt) => {
            return dayjs(createdAt).fromNow()
        }

        const receiveFriend = (userId) => {
            axios.patch(`/users/friends/${userId}`)
                .then((res) => {
                    console.log(res.data);
                })
                .catch((err) => console.error(err));
        }

        return { relativeCreatedAt, receiveFriend }
    },
});
</script>

<style scoped>

</style>

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
                                        <img :src="user.profile_photo_url" alt="profile" />
                                        <div class="mx-2 -mt-1">
                                            {{ user.name }}
                                        </div>
                                        <button @click="requestFriend(user.id)">친구 추가</button>
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
export default defineComponent({
    components: {
        Link,
    },
    props: ['user'],
    setup() {

        const requestFriend = (userId) => {
            axios.get(`/users/friends/${userId}/notifications`)
                .then((res) => console.log(res.data))
                .catch((err) => console.error(err));
        }

        return { requestFriend }
    },
});
</script>

<style scoped>

</style>

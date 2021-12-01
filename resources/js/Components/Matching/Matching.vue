<template>
    <main class="h-full w-full bg-gray-50 flex items-center justify-center">
        <div class="border max-w-screen-md bg-white mt-6 rounded-2xl p-4">
            <div class="flex items-center	justify-between">
                <div class="bg-gray-100	rounded-full h-3.5 flex	items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="34px" fill="#92929D">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="whitespace-pre-wrap mt-7">{{ matching.man.name }} 님과 {{ matching.woman.name }} 님이 매칭</div>
            <div class="mt-5 flex gap-2	 justify-center border-b pb-4 flex-wrap	">
                <img :src="matching.man.profile_photo_url" alt="profile"/>
                <img :src="matching.woman.profile_photo_url" alt="profile"/>
            </div>
        </div>
    </main>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
    props: ['matching'],
    setup(props) {
    }
})
</script>

<style scoped>

</style>

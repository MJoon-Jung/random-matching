<template>
    <div>
        <div
            class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg"
        >
            <div class="h-20 w-20 rounded-full border overflow-hidden">
                <img
                    :src="$page.props.user.profile_photo_url"
                    alt="Avatar"
                    class="h-full w-full"
                />
            </div>
            <div class="text-sm font-semibold mt-2">{{ $page.props.user.name }}</div>
            <div class="text-xs text-gray-500">{{ $page.props.user.email }}</div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
})
</script>

<style scoped>

</style>

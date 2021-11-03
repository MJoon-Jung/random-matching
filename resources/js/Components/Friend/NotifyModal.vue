<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="font-bold text-2xl mb-2 text-center">
                알림
            </div>
        </template>

        <template #content>
            <div v-if="notifications.length" class="flex-col">
                <div v-for="notification in notifications" :key="notification.id">
                    <notify-list :notification="notification"/>
                </div>
            </div>
            <div v-else class="text-center">
                알림이 없습니다
            </div>
        </template>

        <template #footer>
            ㅎㅇ
        </template>
    </jet-dialog-modal>
</template>

<script>
import {defineComponent} from "vue";
import JetDialogModal from '../../Jetstream/DialogModal'
import {Link} from "@inertiajs/inertia-vue3";
import NotifyList from "./NotifyList";
import {Inertia} from "@inertiajs/inertia";

export default defineComponent({
    components: {
        JetDialogModal,
        NotifyList,
        Link
    },
    props: ['show', 'close', 'notifications'],
    setup() {
        axios.patch('/users/notification')
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => console.error(err));

        return { };
    },
})
</script>

<style scoped>

</style>

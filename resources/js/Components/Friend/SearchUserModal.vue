<template>
    <jet-dialog-modal :show="show" @close="close">
        <template #title>
            <div class="font-bold text-2xl mb-2 text-center">
                Search User
            </div>
        </template>

        <template #content>
            <div class="flex flex-col">
                <input type="text" v-model="search" class="h-full w-full bg-gray-50 outline-none" placeholder="이름 검색">
                <button @click="searchUser" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2" >검색</button>
            </div>
        </template>

        <template #footer>
            <div class="flex-col">
                <div v-for="user in userList">
                    <user-list :user="user" />
                </div>
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>
import {defineComponent, ref} from "vue";
import JetDialogModal from '../../Jetstream/DialogModal'
import UserList from "./UserList";
export default defineComponent({
    components: {
        JetDialogModal,
        UserList,
    },
    props: ['show', 'close'],
    setup() {
        const search = ref('');
        const userList = ref([]);
        // const awaitingSearch = ref(false);

        const searchUser = () => {
            axios.get(`/users/search?name=${search.value}`)
                .then((res) => userList.value=res.data)
                .catch((err) => console.error(err));
        };

        return { search, searchUser, userList };
    },
})
</script>

<style scoped>

</style>

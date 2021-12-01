<template>
    <app-layout title="채널">
        <div class="flex-1 flex h-screen antialiased text-gray-800">
            <div class="flex flex-row h-full w-full overflow-x-hidden">
                <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">
                    <div class="flex flex-row items-center justify-center h-12 w-full">
                        <div
                            class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                ></path>
                            </svg>
                        </div>
                        <div class="ml-2 font-bold text-2xl">랜덤 채팅방</div>
                    </div>
                    <RandomChatProfile v-for="member in channel.members" :key="member.id" :member="member"/>
                    <Link :href="route('match.index')">연결 끊기</Link>
                </div>
                <div class="flex flex-col flex-auto h-[calc(100vh-72px)] p-6">
                    <div
                        class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4"
                    >
                        <div ref="chattingListScroll" class="flex flex-col h-full overflow-x-auto overflow-scroll">
                            <div class="flex flex-col h-full">
                                <div class="grid grid-cols-12 gap-y-2">
                                    <Chat v-for="chatMessage in chatMessages" :chat="chatMessage"/>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4"
                        >
                            <div>
                                <button
                                    class="flex items-center justify-center text-gray-400 hover:text-gray-600"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-grow ml-4">
                                <div class="relative w-full">
                                    <input
                                        type="text"
                                        v-model="chatMessage"
                                        class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"
                                    />
                                    <button
                                        class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600"
                                    >
                                        <svg
                                            class="w-6 h-6"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="ml-4">
                                <button
                                    @click="handleSendChatMessage"
                                    class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0"
                                >
                                    <span>Send</span>
                                    <span class="ml-2">
                                      <svg
                                          class="w-4 h-4 transform rotate-45 -mt-px"
                                          fill="none"
                                          stroke="currentColor"
                                          viewBox="0 0 24 24"
                                          xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                        ></path>
                                      </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, ref, watch} from "vue";
import ChatForm from "../../Components/Channel/ChatForm";
import AppLayout from "../../Layouts/AppLayout";
import RandomChatProfile from "../../Components/Channel/RandomChatProfile";
import ChannelList from "../../Components/Channel/ChannelList";
import Chat from "../../Components/Channel/Chat";
import { Link } from '@inertiajs/inertia-vue3';
import {getEcho} from "../../Socket/Video";

export default defineComponent({
    components: {Chat, ChannelList, AppLayout, ChatForm, RandomChatProfile, Link},
    props: ['channel'],
    setup(props) {
    //채팅방 pusher
        const chatMessages = ref([]);
        const chatMessage = ref(null);

        const chattingListScroll = ref(null);

        const channel = window.Echo.join(`channel.${props.channel.id}`);

        const handleSendChatMessage = () => {
            axios.post(`/chat/channels/${props.channel.id}`, { message: chatMessage.value})
                .catch((err) => console.error(err));
        }

        channel.listen('.new.message', ({chat}) => {
            chatMessages.value.push(chat);
            //셋타임을 안주면 제대로 안내려가짐
            setTimeout(() => {
                chattingListScroll.value.scrollTop = chattingListScroll.value.scrollHeight;
            }, 0)
        })

        return { handleSendChatMessage, chatMessage, chatMessages, chattingListScroll };
    }
})
</script>

<style scoped>

</style>

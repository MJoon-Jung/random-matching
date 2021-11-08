<template>
    <app-layout title="채널">
        <div class="flex h-screen antialiased text-gray-800">
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
                        <div class="ml-2 font-bold text-2xl">채팅방</div>
                    </div>
                    <Profile/>
                    <div class="flex flex-col mt-8">
                        <div class="flex flex-row items-center justify-between text-xs">
                            <span class="font-bold">Active Conversations</span>
                            <span
                                class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full"
                            >{{ $page.props.user.channels.length }}</span
                            >
                        </div>
                        <div class="flex flex-col space-y-1 mt-4 -mx-2 h-48 overflow-y-auto">
                            <ChannelList v-on:changeCurrentChannel="changeCurrentChannel"/>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-auto h-full p-6">
                    <div
                        class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4"
                    >
                        <div class="flex flex-col h-full overflow-x-auto mb-4">
                            <div class="flex flex-col h-full">
                                <div class="grid grid-cols-12 gap-y-2">
                                    <Chat v-if="currentChannel"
                                          v-for="chat in chats[currentChannel]"
                                          :chat="chat"/>
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
import {computed, defineComponent, onUnmounted, ref, watch} from "vue";
import ChatForm from "../../Components/Channel/ChatForm";
import AppLayout from "../../Layouts/AppLayout";
import {usePage} from "@inertiajs/inertia-vue3";
import Profile from "../../Components/Channel/Profile";
import ChannelList from "../../Components/Channel/ChannelList";
import Chat from "../../Components/Channel/Chat";

export default defineComponent({
    components: {Chat, ChannelList, Profile, AppLayout, ChatForm},
    props: ['info'],
    setup(props) {
        //채팅방 pusher
        const channels = ref([]);
        const chats = ref({});
        props.info.channels.map((channel) => {
            channels.value.push(window.Echo.join(`channel.${channel.id}`));
        });
        channels.value.map((channel) => {
            //https://pusher.com/docs/channels/using_channels/presence-channels/#events
            //가입 시 사용자 인증 프로세스가 트리거된다.
            //일단 프리젠테이션 채널에 가입하면, 회원 반복자를 통해 이벤트가 트리거된다. 이를테면 사용자 목록을 작성하는 데 사용할 수 있다.
            channel.here((members) => {
                //
            });
            //사용자가 채널에 가입할 때 이벤트가 트리거됨
            channel.joining((member) => {
                console.log(member.name);
            });
            channel.listen('.new.message', (chat) => {
                console.log(chat);
                chats.value[currentChannel.value].push(chat);
            });
        });
        onUnmounted(() => {
            channels.value.map((channel) => {
                //사용자가 채널을 종료할 때 트리거됨
                channel.leaving((member) => {
                    console.log(member.name);
                    remove_member(member.id, member.info);
                });
            });
        });

        const channelJoin = () => {
            axios.patch('/channels/1')
                .then((res) => {
                    console.log(res.data);
                    channels.value.push(res.data);
                    console.log(channels.value);
                })
                .catch((err) => console.error(err));
        }

        const user = computed(() => usePage().props.value.user)
        console.log(user.value)

        const currentChannel = ref(null);

        const changeCurrentChannel = (channel) => {
            currentChannel.value = channel;
        }

        const loadChatsByChannel = (channel) => {
            if (chats.value[channel]) {
                return
            }
            axios.get(`/channels/${channel}/chats`)
                .then((res) => {
                    chats.value[res.data.id] = res.data.chats;
                    console.log('chats.value', chats.value);
                })
                .catch((err) => console.error(err));
        };

        watch(currentChannel, (val, oldVal) => {
            console.log(val);
            loadChatsByChannel(val);
        })

        return {channelJoin, channels, currentChannel, changeCurrentChannel, chats};
    }
})
</script>

<style scoped>

</style>

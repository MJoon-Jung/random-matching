<template>
    <app-layout title="channel">
        <button @click="channelJoin">1번 채널 들어가기</button>
        <ChatForm/>
        <div>
            <div v-for="channel in info.channels" :key="channel.id">
                <Channel :channel="channel" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, onUnmounted, ref} from "vue";
import ChatForm from "../../Components/Channel/ChatForm";
import AppLayout from "../../Layouts/AppLayout";
import Channel from "../../Components/Channel/Channel";

export default defineComponent({
    components: {Channel, AppLayout, ChatForm},
    props: ['info'],
    setup(props) {
        const channels = ref([]);
        props.info.channels.map((channel) => {
            channels.value.push(window.Echo.join(`channel.${channel.id}`));
        });
        channels.value.map((channel)=> {
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
            channel.listen('.new.message', (event) => {
                console.log(event);
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

        return {channelJoin, channels};
    }
})
</script>

<style scoped>

</style>

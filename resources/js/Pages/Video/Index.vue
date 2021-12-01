<template>
    <app-layout title="화상">
        <!--        <div v-if="!peerStream?.srcObject" class="flex-1 flex justify-center items-center mb-48">-->
        <!--            <svg class="animate-spin h-48 w-48 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
        <!--                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
        <!--                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
        <!--            </svg>-->
        <!--        </div>-->
        <div class="flex justify-between">
            <div class="flex flex-wrap justify-center place-items-center h-screen">
                <div class="text-center">
                    <p class="text-xl">
                        <img class="h-8 w-8 rounded-full object-cover transform translate-y-180"
                             :src="$page.props.user.profile_photo_url"
                             alt="profile_photo"/>
                        {{ $page.props.user.name }}
                    </p>
                    <video ref="myFace" autoplay playsinline width="600" height="600"/>
                    <div class="flex">
                        <button @click="handleMute"
                                class="flex p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-600 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                            <svg v-if="deviceOff.muted" xmlns="http://www.w3.org/2000/svg"
                                 enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px"
                                 fill="#000000">
                                <g>
                                    <rect fill="none" height="24" width="24"/>
                                    <rect fill="none" height="24" width="24"/>
                                    <rect fill="none" height="24" width="24"/>
                                </g>
                                <g>
                                    <g/>
                                    <g>
                                        <path
                                            d="M12,14c1.66,0,3-1.34,3-3V5c0-1.66-1.34-3-3-3S9,3.34,9,5v6C9,12.66,10.34,14,12,14z"/>
                                        <path
                                            d="M17,11c0,2.76-2.24,5-5,5s-5-2.24-5-5H5c0,3.53,2.61,6.43,6,6.92V21h2v-3.08c3.39-0.49,6-3.39,6-6.92H17z"/>
                                    </g>
                                </g>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24"
                                 width="24px" fill="#000000">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path
                                    d="M10.8 4.9c0-.66.54-1.2 1.2-1.2s1.2.54 1.2 1.2l-.01 3.91L15 10.6V5c0-1.66-1.34-3-3-3-1.54 0-2.79 1.16-2.96 2.65l1.76 1.76V4.9zM19 11h-1.7c0 .58-.1 1.13-.27 1.64l1.27 1.27c.44-.88.7-1.87.7-2.91zM4.41 2.86L3 4.27l6 6V11c0 1.66 1.34 3 3 3 .23 0 .44-.03.65-.08l1.66 1.66c-.71.33-1.5.52-2.31.52-2.76 0-5.3-2.1-5.3-5.1H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c.91-.13 1.77-.45 2.55-.9l4.2 4.2 1.41-1.41L4.41 2.86z"/>
                            </svg>
                            {{ deviceOff.muted ? '소리' : '음소거' }}
                        </button>
                        <button @click="handleCamera"
                                class="flex p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-600 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                            <svg v-if="deviceOff.cameraOff" xmlns="http://www.w3.org/2000/svg" height="24px"
                                 viewBox="0 0 24 24" width="24px" fill="#000000">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path
                                    d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 13H3V5h18v11z"/>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24"
                                 width="24px" fill="#000000">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path
                                    d="M21.79 18l2 2H24v-2h-2.21zM1.11 2.98l1.55 1.56c-.41.37-.66.89-.66 1.48V16c0 1.1.9 2 2.01 2H0v2h18.13l2.71 2.71 1.41-1.41L2.52 1.57 1.11 2.98zM4 6.02h.13l4.95 4.93C7.94 12.07 7.31 13.52 7 15c.96-1.29 2.13-2.08 3.67-2.46l3.46 3.48H4v-10zm16 0v10.19l1.3 1.3c.42-.37.7-.89.7-1.49v-10c0-1.11-.9-2-2-2H7.8l2 2H20zm-7.07 3.13l2.79 2.78 1.28-1.2L13 7v2.13l-.07.02z"/>
                            </svg>
                            {{ deviceOff.cameraOff ? '카메라 키기' : '카메라 끄기' }}
                        </button>
                        <select v-if="selectedCamera" v-model="selectedCamera.deviceId">
                            <option v-for="camera in cameras" :key="camera.deviceId" :value="camera.deviceId">
                                {{ camera.label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center place-items-center h-screen">
                <button @click="handleLeaveRoom" class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="60px" viewBox="0 0 24 24" width="60px"
                         fill="#000000">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                    </svg>
                </button>
            </div>
            <div class="flex flex-wrap justify-center place-items-center h-screen">
                <div class="text-center">
                    <p class="text-xl">
                        <img class="h-8 w-8 rounded-full object-cover"
                             :src="member?.photo"
                             alt="profile_photo"/>
                        {{ member?.name }}
                    </p>
                    <video ref="peerStream" autoplay playsinline width="600" height="600"
                           :disabled="!peerStream?.srcObject"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {computed, defineComponent, onBeforeUnmount, ref, watch} from "vue";
import AppLayout from "../../Layouts/AppLayout";
import {handleMuteOnStream, handleCameraOnStream, getEcho} from "../../Socket/Video";
import {Inertia} from "@inertiajs/inertia";
import {usePage} from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: ['channelId'],
    components: {AppLayout},
    setup(props) {

        const user = computed(() => usePage().props.value.user)
        //webrtc
        const deviceOff = ref({
            cameraOff: false,
            muted: false,
        });
        //video 키는 코드
        const myFace = ref(null);
        const myStream = ref(null);
        const myPeerConnection = ref(null);

        const cameras = ref(null);
        const selectedCamera = ref(null);

        const peerStream = ref(null);
        const isMatching = ref(false);

        const channel = window.Echo.join(`videoChat.${props.channelId}`);

        const member = ref(null);

        async function getCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                cameras.value = devices.filter((device) => device.kind === 'videoinput');
                const currentCamera = myStream.value.getVideoTracks()[0];

                cameras.value.forEach((camera) => {
                    selectedCamera.value = currentCamera.label === camera.label ? camera : null;
                })

            } catch (err) {
                console.error(err);
            }
        }

        async function getMedia(deviceId) {
            const initialConstraints = {
                audio: false,
                video: {facingMode: true}
            };
            const cameraConstraints = {
                audio: false,
                video: {deviceId: {exact: deviceId}},
            };
            try {
                myStream.value = await navigator.mediaDevices.getUserMedia(
                    deviceId ? cameraConstraints : initialConstraints
                )
                myFace.value.srcObject = myStream.value;
                deviceId || await getCameras();
            } catch (err) {
                console.error(err);
            }
        }


        async function handleCameraChange() {
            await getMedia(selectedCamera.value.deviceId);
        }

        const makeConnection = () => {
            myPeerConnection.value = new RTCPeerConnection();
            myPeerConnection.value.onicecandidate = handleIce;
            myPeerConnection.value.ontrack = handleOnTrack;
            //video stream 하나만 넘겨줌
            const track = myStream.value.getTracks().map((track) => {
                return track.label === selectedCamera.value.label ? track : null;
            })[0];
            myPeerConnection.value.addTrack(track, myStream.value);
        }

        function handleIce(data) {
            console.log('ice 생성')
            channel.whisper('ice', data.candidate);
            console.log('ice 보냄')
        }

        function handleOnTrack(data) {
            peerStream.value.srcObject = data.streams[0];
            isMatching.value = true;
        }

        async function initCall() {
            await getMedia();
            makeConnection();
        }

        const handleCamera = () => handleCameraOnStream(myStream.value, deviceOff.value);
        const handleMute = () => handleMuteOnStream(myStream.value, deviceOff.value);

        const handleLeaveRoom = () => {
            const answer = confirm('나가시겠습니까?');
            if (answer) {
                Inertia.get('/matching/video')
            }
        }

        //socket pusher
        //사용자가 채널에 가입할 때 이벤트가 트리거됨
        channel
            .here(async (members) => {
                try {
                    await initCall();
                    if (members.length > 1) {
                        const offer = await myPeerConnection.value.createOffer();
                        myPeerConnection.value.setLocalDescription(offer);
                        channel.whisper('offer', offer);
                        console.log(members);
                        member.value = members[1];
                        console.log(member.value);
                    }
                } catch (err) {
                    console.error(err);
                }
            })
            .joining(async (channelMember) => {
                console.log(`${channelMember.name} 님이 참가했습니다.`);
                member.value = channelMember;
            })
            .listenForWhisper('offer', async (offer) => {
                console.log('offer 받음')
                myPeerConnection.value.setRemoteDescription(offer);
                const answer = await myPeerConnection.value.createAnswer();
                myPeerConnection.value.setLocalDescription(answer);
                console.log('answer 생성')
                channel.whisper('answer', answer);
                console.log('answer 전송')
            })
            .listenForWhisper('answer', (answer) => {
                myPeerConnection.value.setRemoteDescription(answer);
                console.log('answer 받음')
            })
            .listenForWhisper('ice', (ice) => {
                console.log('ice 받음')
                myPeerConnection.value.addIceCandidate(ice);
            })
            .leaving((member) => {
                console.log(`${member.name} 님이 나가셨습니다.`);
                peerStream.value.srcObject = null;
                myPeerConnection.value.close();
                // Inertia.get('/matching')
                //다시 초기셋팅
                makeConnection();
            })


        //카메라 변경
        watch(selectedCamera.value, async (val, oldVal) => {
            await handleCameraChange(val);
        });

        onBeforeUnmount(() => {
            window.Echo.leave(`videoChat.${props.channelId}`);
            myPeerConnection.value.close();
        });

        return {myFace, handleCamera, deviceOff, handleMute, cameras, selectedCamera, peerStream, handleLeaveRoom, member};
    },
})
</script>

<style scoped>

</style>

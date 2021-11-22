<template>
    <app-layout title="화상">
        <div class="flex justify-between">
            <div class="flex flex-wrap justify-center place-items-center h-screen">
                <div class="text-center">
                    <video ref="myFace" autoplay playsinline width="600" height="600"/>
                    <button @click="handleMute"
                            class="p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-600 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                        {{ deviceOff.muted ? '소리' : '음소거' }}
                    </button>
                    <button @click="handleCamera"
                            class="p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-600 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                        {{ deviceOff.cameraOff ? '카메라 키기' : '카메라 끄기' }}
                    </button>
                    <select v-if="selectedCamera" v-model="selectedCamera.deviceId">
                        <option v-for="camera in cameras" :key="camera.deviceId" :value="camera.deviceId">
                            {{ camera.label }}
                        </option>
                    </select>
                </div>
            </div>
            <video ref="peerStream" autoplay playsinline width="600" height="600" :disabled="!peerStream?.srcObject" />
        </div>
<!--        <div v-else class="flex-1 flex justify-center items-center mb-48">-->
<!--            <svg class="animate-spin h-48 w-48 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
<!--                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--            </svg>-->
<!--        </div>-->
    </app-layout>
</template>

<script>
import {defineComponent, onUnmounted, ref, watch} from "vue";
import AppLayout from "../../Layouts/AppLayout";
import { handleMuteOnStream, handleCameraOnStream,getEcho} from "../../Socket/Video";

export default defineComponent({
    props: ['channelId'],
    components: {AppLayout},
   setup(props) {


        //webrtc
        const deviceOff = ref({
            cameraOff: false,
            muted: false,
        })
        //video 키는 코드
        const myFace = ref(null);
        const myStream = ref(null);
        const myPeerConnection = ref(null);

        const cameras = ref(null);
        const selectedCamera = ref(null);

        const peerStream = ref(null);
        const isMatching = ref(false);

        const Echo = getEcho();
        const channel = Echo.join(`videoChat.${props.channelId}`);


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
                video: {facingMode: "user"}
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
            myStream.value.getTracks().forEach((track) => myPeerConnection.value.addTrack(track, myStream.value));
        }
        function handleIce (data) {
            console.log('ice 생성')
            channel.whisper('ice', data.candidate);
            console.log('ice 보냄')
        }
        function handleOnTrack (data) {
            peerStream.value.srcObject = data.streams[0];
            isMatching.value = true;
        }

        async function initCall() {
            await getMedia();
            makeConnection();
        }

        const handleCamera = () => handleCameraOnStream(myStream.value, deviceOff.value);
        const handleMute = () => handleMuteOnStream(myStream.value, deviceOff.value);

        (async () => {
            await initCall();
        })()


        //socket pusher
        //사용자가 채널에 가입할 때 이벤트가 트리거됨
        channel
            .here(async (members) => {
                console.log(members.length)
                myPeerConnection.value.onicecandidate || makeConnection()
                if (members.length > 1) {
                    const offer = await myPeerConnection.value.createOffer();
                    setTimeout(async () => {
                        myPeerConnection.value.setLocalDescription(offer);
                        console.log('offer 생성')
                        channel.whisper('offer', offer);
                        console.log('offer 전송')
                    }, 1000)
                }
            })
            .joining(async (member) => {
                // myPeerConnection.value.onicecandidate || makeConnection()
                console.log(`${member.name} 님이 참가했습니다.`);
                // const offer = await myPeerConnection.value.createOffer();
                // myPeerConnection.value.setLocalDescription(offer);
                // channel.whisper('offer', offer);
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
                //다시 초기셋팅
                makeConnection();
            })


        //카메라 변경
        watch(selectedCamera.value, async (val, oldVal) => {
            await handleCameraChange(val);
        });

        onUnmounted(() => {
            makeConnection();
        })

        return {myFace, handleCamera, deviceOff, handleMute, cameras, selectedCamera, peerStream };
    },
})
</script>

<style scoped>

</style>

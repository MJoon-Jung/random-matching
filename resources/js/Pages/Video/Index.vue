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
    </app-layout>
</template>

<script>
import {defineComponent, onUnmounted, ref, watch} from "vue";
import AppLayout from "../../Layouts/AppLayout";
import { handleMuteOnStream, handleCameraOnStream,getEcho} from "../../Socket/Video";

export default defineComponent({
    components: {AppLayout},
   setup() {


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

        const channelId = "0499f659-5df9-3996-ab3a-47eae7c3e832"
        const Echo = getEcho();
        const channel = Echo.join(`videoChat.${channelId}`);


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
            channel.whisper('ice', data.candidate);
        }
        function handleOnTrack (data) {
            peerStream.value.srcObject = data.streams[0];
        }

        async function initCall() {
            await getMedia();
            makeConnection();
        }

        const handleCamera = () => handleCameraOnStream(myStream.value, deviceOff.value)
        const handleMute = () => handleMuteOnStream(myStream.value, deviceOff.value)

        initCall()

        //socket pusher
        //사용자가 채널에 가입할 때 이벤트가 트리거됨
        channel
            .joining(async (member) => {
                myPeerConnection.value.onicecandidate || makeConnection()
                console.log(`${member.name} 님이 참가했습니다.`);
                const offer = await myPeerConnection.value.createOffer();
                myPeerConnection.value.setLocalDescription(offer);
                channel.whisper('offer', offer);
            })
            .listenForWhisper('offer', async (offer) => {
                myPeerConnection.value.setRemoteDescription(offer);
                const answer = await myPeerConnection.value.createAnswer();
                myPeerConnection.value.setLocalDescription(answer);
                channel.whisper('answer', answer);
            })
            .listenForWhisper('answer', (answer) => {
                myPeerConnection.value.setRemoteDescription(answer);
            })
            .listenForWhisper('ice', (ice) => {
                myPeerConnection.value.addIceCandidate(ice);
            })
            .leaving((member) => {
                console.log(`${member.name} 님이 나가셨습니다.`);
                peerStream.value.srcObject = null;
                //다시 초기셋팅
                makeConnection();
            });


        //카메라 변경
        watch(selectedCamera.value, async (val, oldVal) => {
            await handleCameraChange(val);
        });

        onUnmounted(() => {
            Echo.leave(`videoChat.${channelId}`);
            makeConnection();
        })

        return {myFace, handleCamera, deviceOff, handleMute, cameras, selectedCamera, peerStream };
    },
})
</script>

<style scoped>

</style>

<template>
    <app-layout title="화상">
        <div class="flex flex-wrap justify-center place-items-center h-screen">
            <div class="text-center">
                <video ref="myFace" autoplay playsinline width="400" height="400"/>
                <button @click="handleMute"
                        class="p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                    {{ muted ? '소리' : '음소거' }}
                </button>
                <button @click="handleCamera"
                        class="p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                    {{ cameraOff ? '카메라 키기' : '카메라 끄기' }}
                </button>
            </div>
            <select v-if="selectedCamera" v-model="selectedCamera.deviceId">
                <option v-for="camera in cameras" :key="camera.deviceId" :value="camera.deviceId">
                    {{camera.label }}
                </option>
            </select>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, ref, watch} from "vue";
import AppLayout from "../../Layouts/AppLayout";

export default defineComponent({
    components: {AppLayout},
    setup() {
        const cameraOff = ref(false);
        const muted = ref(false);
        //video 키는 코드
        const myFace = ref(null);
        const myStream = ref(null);

        const cameras = ref(null);
        const selectedCamera = ref(null);


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
                audio: true,
                video: {facingMode: "user"}
            };
            const cameraConstraints = {
                audio: true,
                video: { deviceId: { exact: deviceId} },
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

        const handleCamera = () => {
            myStream.value
                .getVideoTracks()
                .forEach((track) => track.enabled = !track.enabled);
            cameraOff.value = !cameraOff.value;
        };
        const handleMute = () => {
            myStream.value
                .getAudioTracks()
                .forEach((track) => track.enabled = !track.enabled);
            muted.value = !muted.value;
        };

        async function handleCameraChange() {
            await getMedia(selectedCamera.value.deviceId);
        }

        getMedia();

        watch(selectedCamera.value, async (val, oldVal) => {
            await handleCameraChange(val);
        });

        return {myFace, handleCamera, cameraOff, handleMute, muted, cameras, selectedCamera};
    },
})
</script>

<style scoped>

</style>

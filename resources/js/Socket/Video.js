import Echo from "laravel-echo";

export const handleCameraOnStream = (myStream, deviceOff) => {
    myStream
        .getVideoTracks()
        .forEach((track) => track.enabled = !track.enabled);
    deviceOff.cameraOff = !deviceOff.cameraOff;
};

export const handleMuteOnStream = (myStream, deviceOff) => {
    myStream
        .getAudioTracks()
        .forEach((track) => track.enabled = !track.enabled);
    deviceOff.muted = !deviceOff.muted;
};

export const getEcho = () => {
    return new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        forceTLS: true
    });
}

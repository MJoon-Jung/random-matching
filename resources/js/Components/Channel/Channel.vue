<template>
    <div>
        <button @click="enterChannel">채널 이름 {{ channel.name }}</button>
    </div>
</template>

<script>
import {defineComponent} from "vue";
export default defineComponent({
    props: ['channel'],
    setup(props) {
        const enterChannel = () => {

        }

        return { enterChannel };
    }
})
</script>

<style scoped>

</style>

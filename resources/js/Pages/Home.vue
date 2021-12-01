<template>
    <app-layout title="홈">
        <Matching v-for="matching in matchings" :key="matching.id" :matching="matching"/>
<!--        <div class="result" v-for="matching in matchings" :key="matching.id">-->
<!--            <div>{{ matching.type }}</div>-->
<!--        </div>-->
        <InfiniteLoading :matchings="matchings" @infinite="load" />
    </app-layout>
</template>

<script>
import {defineComponent, ref} from "vue";
import AppLayout from "../Layouts/AppLayout";
import Matching from '../Components/Matching/Matching.vue';
import InfiniteLoading from "v3-infinite-loading";
export default defineComponent({
    components: {AppLayout, Matching,InfiniteLoading},
    props: ['matchings'],
    setup: function (props) {
        const matchings = ref(props.matchings.data);
        const lastId = ref(null);
        const take = 10;

        // axios.get('/matching')
        //     .then((res) => {
        //         matchings.value = res.data.data;
        //     })
        //     .catch((err) => console.error(err));
        const load = async $state => {
            console.log("loading...");
            try {
                lastId.value = matchings.value.length ? matchings.value[matchings.value.length - 1].id : null;
                const api = lastId.value ? `/home?lastId=${lastId.value}` : '/matching';
                const response = await axios.get(api);
                const data = response.data.data;
                if (data.length < take) $state.complete();
                else {
                    matchings.value.push(...data);
                    $state.loaded();
                }
            } catch (error) {
                $state.error();
            }
        }
        return {matchings, load};
    }
})
</script>

<style>
/*#app {*/
/*    font-family: Avenir, Helvetica, Arial, sans-serif;*/
/*    -webkit-font-smoothing: antialiased;*/
/*    -moz-osx-font-smoothing: grayscale;*/
/*    text-align: center;*/
/*    color: #2c3e50;*/
/*    margin-top: 60px;*/
/*}*/

/*.result {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    gap: 5px;*/
/*    font-weight: 300;*/
/*    width: 400px;*/
/*    padding: 10px;*/
/*    text-align: center;*/
/*    margin: 0 auto 10px auto;*/
/*    background: #eceef0;*/
/*    border-radius: 10px;*/
/*}*/
</style>

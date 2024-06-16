<template>
    <div class="d-flex">
        <Sidebar @show-result="handleShowResult"/>
        <Main :showResultGift="showResult"/>
    </div>
</template>

<script>
import Main from '../Components/Main.vue'
import Sidebar from "../components/Sidebar.vue";

export default {
    mounted() {
        console.log('Component mounted.')
    },
    components: {
        Main,
        Sidebar,
    },
    data() {
        return {
            showResult: null, // Initialize to false or as needed
        };
    },
    methods: {
        handleShowResult(showResult) {
            this.showResult = showResult;
        }
    },

}
</script>

<template>
    <div>
        <Sidebar/>
        <Main/>
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
    }
}
</script>

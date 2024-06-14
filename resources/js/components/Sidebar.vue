<template>
    <div class="sidebar">
        <div class="top">
            <img alt="" class="menu" src="@/assets/menu_icon.png" @click="toggleExtended"/>
            <div class="new-chat" @click="newChat">
                <img alt="" src="/imgs/plus_icon.png"/>
                <p v-if="extended">New Chat</p>
            </div>
            <div v-if="extended" class="recent">
                <p class="recent-title">Recent</p>
                <div class="recent-entry">
                    <img alt="" src="/imgs/message_icon.png"/>
                    <p>What is react...</p>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div v-for="(item, index) in bottomItems" :key="index" class="bottom-item recent-entry">
                <img :src="item.icon" alt=""/>
                <p v-if="extended">{{ item.label }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            extended: true,
            bottomItems: [
                { icon: '/imgs/question_icon.png', label: 'Help' },
                { icon: '/imgs/history_icon.png', label: 'Activity' },
                { icon: '/imgs/setting_icon.png', label: 'Settings' }
            ]
        };
    },
    methods: {
        toggleExtended() {
            this.extended = !this.extended;
        },
        newChat() {
            // Implement logic for new chat functionality
        }
    }
};
</script>

<style scoped>
.sidebar {
    /* Your sidebar styles */
}

/* Add your CSS styles here */
</style>

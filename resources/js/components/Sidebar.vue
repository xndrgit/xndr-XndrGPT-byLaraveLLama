<template>
    <div class="sidebar">
        <div class="top">
            <img alt="" class="menu" src="/imgs/menu_icon.png" @click="toggleExtended"/>
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

<style lang="scss" scoped>
.sidebar {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #f0f4f9;
    padding: 25px 15px;

    img {
        width: 20px;
    }

    .menu {
        display: block;
        margin-left: 10px;
        cursor: pointer;
    }

    .new-chat {
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        background: #e6eaf1;
        border-radius: 50px;
        font-size: 14px;
        color: grey;
        cursor: pointer;
    }

    .recent {
        display: flex;
        flex-direction: column;
        animation: fadeIn 1.5s;
    }

    .recent-title {
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .recent-entry {
        display: flex;
        align-items: start;
        gap: 10px;
        padding: 10px 40px 10px 10px;
        border-radius: 50px;
        color: #282828;
        cursor: pointer;

        &:hover {
            background: #e2e6eb;
        }
    }

    .bottom {
        display: flex;
        flex-direction: column;

        .bottom-item {
            padding-right: 10px;
            cursor: pointer;
        }
    }

    @media (max-width: 600px) {
        display: none;
    }
}
</style>

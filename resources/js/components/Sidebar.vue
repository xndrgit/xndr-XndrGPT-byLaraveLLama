<template>
    <div class="sidebar">
        <div class="top d-flex flex-column align-items-center justify-content-center">
            <img alt="" class="m-0 menu" src="/imgs/menu_icon.png" @click="toggleExtended"/>
            <div class="new-chat" @click="show">
                <img alt="" src="/imgs/house.png"/>
                <p v-if="extended">Home</p>
            </div>
            <div v-if="extended" class="recent">
                <p class="recent-title text-center fw-bold">Recent</p>
                <div class="recent-entry" @click="hide">
                    <img alt="" src="/imgs/message_icon.png"/>
                    <p>Hello, Xndr. How can I help you today?</p>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div v-for="(item, index) in bottomItems" :key="index" class="bottom-item recent-entry align-items-center">
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
            showResult: false,
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
        show() {
            this.$emit('show-result', false);
        },
        hide() {
            this.$emit('show-result', true);
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
        width: 25px;
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
        padding: 15px;
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
        align-items: center;
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

<template>
    <div class="main">
        <div class="nav">
            <p>XndrGPT</p>
            <img alt="" src="@/assets/user_icon.png"/>
        </div>
        <div class="main-container">
            <!-- Conditional rendering based on showResult -->
            <template v-if="!showResult">
                <div class="greet">
                    <p><span>Hello, Xndr.</span></p>
                    <p>How can I help you today?</p>
                </div>
                <div class="cards">
                    <!-- Repeatable cards -->
                    <div v-for="(_, index) in 4" :key="index" class="card">
                        <p>Suggest beautiful places to see on an upcoming road trip</p>
                        <img alt="" src="@/assets/compass_icon.png"/>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="result">
                    <div class="result-title">
                        <img alt="" src="@/assets/user_icon.png"/>
                        <p>{{ recentPrompt }}</p>
                    </div>
                    <div class="result-data">
                        <img alt="" src="@/assets/gemini_icon.png"/>
                        <!-- Conditional rendering based on resultData -->
                        <template v-if="resultData">
                            <!-- Loading indicator -->
                            <template v-if="loading">
                                <div class="loader">
                                    <hr/>
                                    <hr/>
                                    <hr/>
                                </div>
                            </template>
                            <!-- Result data -->
                            <template v-else>
                                <p v-html="resultData"></p>
                            </template>
                        </template>
                        <!-- Fallback message -->
                        <template v-else>
                            <a href="https://console.cloud.google.com/billing">
                                <p>You can't use me without a billing account linked.</p>
                            </a>
                        </template>
                    </div>
                </div>
            </template>

            <div class="main-bottom">
                <div class="search-box">
                    <input v-model="input" placeholder="Enter a prompt here" type="text"
                           @keypress.enter="handleKeyPress"/>
                    <div>
                        <img v-if="input" alt="" src="@/assets/send_icon.png" @click="onSent"/>
                    </div>
                </div>
                <p class="bottom-info">
                    XndrGPT may display inaccurate info, including about people, do double-check its responses. Your
                    privacy and
                    XndrGPT Apps
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: '',
            showResult: false,
            recentPrompt: '',
            resultData: '',
            loading: false
        };
    },
    methods: {
        onSent() {
            // Implement your logic for handling the sent message
        },
        handleKeyPress(event) {
            if (event.key === 'Enter') {
                this.onSent();
            }
        }
    },
    mounted() {
        console.log('Component mounted.');
        // Additional initialization logic if needed
    }
};
</script>

<template>
    <div class="main">
        <div class="nav">
            <p>XndrGPT</p>
            <img alt="" src="/imgs/user-icon.jpg"/>
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
                        <img alt="" src="/imgs/compass_icon.png"/>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="result">
                    <div class="result-title">
                        <img alt="" src="/imgs/user-icon.jpg"/>
                        <p>{{ recentPrompt }}</p>
                    </div>
                    <div class="result-data">
                        <img alt="" src="/imgs/gemini_icon.png"/>
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
                        <img v-if="input" alt="" src="/imgs/send_icon.png" @click="onSent"/>
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


<style lang="scss" scoped>
.main {
    flex: 1;
    min-height: 100vh;
    //padding-bottom: 15vh;
    position: relative;

    .nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 22px;
        padding: 20px;
        color: #585858;

        img {
            width: 40px;
            border-radius: 50%;
        }
    }

    .main-container {
        max-width: 900px;
        margin: auto;
    }

    .greet {
        margin: 50px 0;
        font-size: 56px;
        color: #c4c7c5;
        font-weight: 500;
        padding: 20px;

        span {
            background: -webkit-linear-gradient(16deg, #4b90ff, #ff5546);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        margin: 50px 20px;

        .card {
            height: 200px;
            padding: 15px;
            background: #f0f4f9;
            border-radius: 10px;
            position: relative;

            img {
                width: 35px;
                padding: 5px;
                position: absolute;
                background: white;
                border-radius: 20px;
                bottom: 10px;
                right: 10px;
            }

            p {
                color: #585858;
                font-size: 17px;
            }

            &:hover {
                background: #dfe4ea;
            }
        }
    }

    .main-bottom {
        position: absolute;
        bottom: 0;
        width: 100%;
        max-width: 900px;
        padding: 0px 20px;
        margin: auto;

        .search-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #f0f4f9;
            padding: 10px 20px;
            border-radius: 50px;

            img {
                width: 24px;
                cursor: pointer;
            }

            input {
                flex: 1;
                background: transparent;
                border: none;
                outline: none;
                padding: 8px;
                font-size: 18px;
            }

            div {
                display: flex;
                align-items: center;
                gap: 15px;
            }
        }

        .bottom-info {
            font-size: 13px;
            margin: 15px auto;
            text-align: center;
            font-weight: 300;
        }
    }

    .result {
        padding: 0 5%;
        max-height: 70vh;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            display: none;
        }

        .result-title {
            margin: 40px 0;
            display: flex;
            align-items: center;
            gap: 20px;

            img {
                width: 40px;
                border-radius: 50%;
            }
        }

        .result-data {
            display: flex;
            align-items: start;
            gap: 20px;

            .loader {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 10px;

                hr {
                    border-radius: 4px;
                    border: none;
                    background: #f6f7f8;
                    background: linear-gradient(to right, #9ed7ff, #ffffff, #9ed7ff);
                    background-size: 800px 50px;
                    height: 20px;

                    animation: loader 3s infinite linear;
                }
            }

            p {
                font-size: 17px;
                font-weight: 300;
                line-height: 1.8;
            }
        }
    }

    @keyframes loader {
        0% {
            background-position: -800px 0;
        }
        100% {
            background-position: 800px 0;
        }
    }

    @media (max-width: 600px) {
        .main-bottom {
            input {
                flex: none;
                width: 150px;
            }

            img {
                width: 20px;
            }

            .search-box {
                padding: 5px 10px;

                div {
                    gap: 5px;
                }
            }
        }
    }
}
</style>

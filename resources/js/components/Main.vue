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
                <div class="cards d-none d-lg-flex">
                    <!-- Repeatable cards -->
                    <div v-for="(card, index) in cards" :key="index" class="card" @click="onSentCard(card.message)">
                        <p>{{ card.message }}</p>
                        <img alt="" src="/imgs/compass_icon.png"/>
                    </div>
                </div>
            </template>
            <div v-else>
                <div ref="chatBox" class="result">
                    <div v-for="(message, index) in history"
                         :key="index" :class="message.from === 'user' ? 'result-title' : 'result-data'">
                        <img :alt="message.from === 'user' ? 'user-icon' : 'laravellama-logo'"
                             :src="message.from === 'user' ? '/imgs/user-icon.jpg' : '/imgs/laravellama-logo.jpg'"/>
                        <p class="p-2">{{ message.message }}</p>
                    </div>

                    <!--                    <div class="result-title">-->
                    <!--                        <img alt="" src="/imgs/user-icon.jpg"/>-->
                    <!--                        <p>{{ recentPrompt }}</p>-->
                    <!--                    </div>-->
                    <div v-if="loading" class="result-data">
                        <a href="https://github.com/xndrgit/xndr-laravellama">
                            <img alt='laravellama-logo' src="/imgs/laravellama-logo.jpg"/>
                        </a>
                        <!-- Loading indicator -->
                        <div v-if="loading" class="loader">
                            <hr/>
                            <hr/>
                            <hr/>
                        </div>
                        <!--                        <p v-else>{{ response }}</p>-->

                        <!--                         Fallback message -->
                        <!--                                                <div>-->
                        <!--                                                    <a href="#">-->
                        <!--                                                        <p>Error404</p>-->
                        <!--                                                    </a>-->
                        <!--                                                </div>-->
                    </div>
                </div>
            </div>

            <div class="main-bottom">
                <div class="search-box">
                    <input v-model="input" placeholder="Enter a prompt here" type="text"
                           @keypress.enter="onSent"/>
                    <div>
                        <img v-if="input" alt="" src="/imgs/send_icon.png" @click="onSent"/>
                    </div>
                </div>
                <p class="bottom-info">
                    XndrGPT may display inaccurate info, including about people, do double-check its responses.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    watch: {
        showResultGift(newValue, oldValue) {
            this.showResult = newValue;
        }
    },
    props: {
        showResultGift: Boolean,
    },
    data() {
        return {
            history: [
                {
                    message: 'Hello, Xndr. How can I help you today?',
                    from: 'bot',
                },
            ],
            cards: [
                {
                    message: 'Do llamas secretly want to be unicorns but just can’t find the right horn?'
                },
                {
                    message: 'Do llamas ever get jealous of alpacas’ fluffiness, or are they just cool with it?'
                },
                {
                    message: 'Are llamas plotting world domination, or are they just content with being adorable?'
                },
                {
                    message: 'If a llama joined a boy band, would it be the lead singer or the backup dancer?'
                },
            ],

            input: '',
            showResult: null,
            recentPrompt: '',
            response: null,
            loading: false
        };
    },
    methods: {
        scrollToBottom() {
            const chatBox = this.$refs.chatBox;
            if (chatBox && chatBox.scrollHeight) {
                const scrollTop = chatBox.scrollHeight;
                chatBox.scrollTo({
                    top: scrollTop,
                    left: 0,
                    behavior: 'smooth'
                });
            }
        },
        onSent(input) {
            if (this.input.trim() === '') return;

            // Add user's prompt to history
            this.history.push({
                message: this.input,
                from: 'user'
            });
            this.scrollToBottom();

            // Implement logic for sending a prompt to the backend
            this.showResult = true;
            this.recentPrompt = this.input;
            this.input = '';
            this.loading = true;


            this.$nextTick(() => {
                this.scrollToBottom();
                this.getResponse();
            });
        },
        onSentCard(input) {
            console.log("card activated");

            // Add user's prompt to history
            this.history.push({
                message: input,
                from: 'user'
            });
            this.scrollToBottom();

            // Implement logic for sending a prompt to the backend
            this.showResult = true;
            this.recentPrompt = this.input;
            this.input = '';
            this.loading = true;


            this.$nextTick(() => {
                this.scrollToBottom();
                this.getResponse();
            });
        },

        async getResponse() {
            try {
                console.log('Sending request with prompt:', this.recentPrompt); // Debugging log
                const res = await fetch('/api/ollama-response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ prompt: this.recentPrompt }),
                });

                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }

                const data = await res.json();
                console.log('Received response:', data); // Debugging log

                this.response = data.response;
            } catch (error) {
                console.error('Error fetching response:', error);
                console.log(error.message);
                this.response = `${error.message} ► Install & Open Ollama to get a response.`;
            } finally {
                this.history.push({
                    message: this.response,
                    from: 'bot'
                });
                this.loading = false;
                this.scrollToBottom();
            }
        },
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
            cursor: pointer;
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
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #888 #f0f4f9; /* Firefox */

        img {
            min-width: 40px;
            width: 40px;
            border-radius: 50%;
        }

        &::-webkit-scrollbar {
            display: none;
        }

        .result-title {
            margin: 40px 0;
            display: flex;
            align-items: start;
            gap: 20px;


        }

        .result-data {
            margin: 40px 0;
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

            //p {
            //    font-size: 17px;
            //    font-weight: 300;
            //    line-height: 1.8;
            //}
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

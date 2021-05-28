<template>
    <div class="chat card" :class="{ 'chat--open': open == true }">
        <div class="card-header" @click="openChat()">{{ uuid }} <i class="fas fa-times ms-4" @click="$root.closeChat(uuid)"></i></div>
        <div class="card-body" v-if="open" :ref="'chatBody'+uuid">
            <div v-for="message in messages" :key="message.id" :class="{ 'chat__message': true, 'chat__message--me': message.me }">
                <div class="chat__username">{{ message.by }}:</div>
                <div class="chat__content">{{ message.content }}</div>
                <div class="chat__date">{{ message.created_at_ago }}</div>
            </div>
        </div>
        <form class="card-footer" v-if="open" @submit.prevent="sendMessage">
            <input type="text" v-model="newMessage" :disabled="lockForm">
            <button :disabled="lockForm"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</template>
<script>
    export default {
        props: {
            uuid: {
                type: String,
                default: ''
            },
            endpoint: {
                type: String,
                default: ''
            }
        },
        components: {},
        data(){
            return{
                open: true,
                messages: [],
                newMessage: '',
                lockForm: true
            }
        },
        created() {},
        mounted () {
            this.getMessages()
            this.lockForm = false
        },
        watch: {},
        methods: {
            openChat() {
                this.open = !this.open
                this.goEnd()
            },
            goEnd() {
                if (this.open) {
                    setTimeout( ()=> {
                        const body = this.$refs['chatBody'+this.uuid]
                        if (body) {
                            body.scrollTop=body.scrollHeight
                        }
                    },200)
                }
            },
            getMessages() {
                let formData = new FormData()
                formData.append('uuid', this.uuid);
                axios.post(this.endpoint, formData).then((response) => {
                    this.messages = response.data.messages
                    this.goEnd()
                    setTimeout( ()=> {
                        this.getMessages()
                    },2000)
                }).catch((error) => {
                    setTimeout( ()=> {
                        this.getMessages()
                    },2000)
                })
            },
            sendMessage() {
                this.lockForm = true
                let formData = new FormData()
                formData.append('uuid',    this.uuid)
                formData.append('message', this.newMessage)
                if (this.newMessage.length > 0) {
                    axios.post(this.endpoint, formData).then((response) => {
                        // this.messages = response.data.messages
                        this.newMessage = '',
                        this.goEnd()
                        this.lockForm = false
                    }).catch((error) => {
                        this.lockForm = false
                    })
                }
            }
        }
  }
</script>
<style lang="scss" scoped>
    .chat {
        margin-left: 7.5px;
        &__message {
            max-width: 75%;
            background-color: #ccc;
            margin-top: 7.5px;
            padding: 0 7.5px 2px 7.5px;
            border: 1px solid #adb5bd;
            border-radius: 0 10px 10px 10px;
            box-shadow: 1px 1px 2px -1px;
            &:nth-child(even) {
                border-radius: 10px 10px 10px 0;
            }
            &--me {
                background-color: #25ce68;
                margin-left: auto;
                border-radius: 10px 10px 0 10px;
                border-color: #13b955;
                &:nth-child(even) {
                    border-radius: 10px 0 10px 10px;
                }
            }
            /*
            &:nth-child(odd) {
                background-color: $duyba-bg-primary;
            }
            */
        }
        &__username {
            font-weight: bold;
            cursor: pointer;
            font-size: 12px;
            color: #000;
            opacity: .7;
            &:hover {
                text-decoration: underline;
            }
        }
        &__content {
            opacity: .9;
        }
        &__date {
            text-align: end;
            font-size: 11px;
            color: #000;
            opacity: .6;
        }
        .card-header {
            font-weight: normal;
            cursor: pointer;
            user-select: none;
            z-index: 99999999999;
        }
        .card-body {
            height: 340px;
            overflow-y: scroll;
        }
        .card-footer {
            padding: 0;
            display: flex;
            input {
                background: none;
                outline: none;
                border: none;
                padding: 0.5rem 1rem;
                flex-grow: 1;
            }
            button {
                outline: none;
                border: none;
                background: transparent;
                padding: 0 10px;
                opacity: 0.7;
            }
        }
        &--open {
            .card-header {
                font-weight: bold;
                background: royalblue;
                color: #fff;
            }
        }
    }
</style>
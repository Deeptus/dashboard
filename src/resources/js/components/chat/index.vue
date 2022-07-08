<template>
    <div class="chat-area">
        <chat :endpoint="endpoint" :params="chat" v-for="chat in chats" :key="chat.uuid" />
    </div>
</template>
<script>
    import chat from './chat'
    export default {
        props: {
            endpoint: {
                type: String,
                default: ''
            }
        },
        components: {
            chat
        },
        data(){
            return{
                chats: []
            }
        },
        created() {},
        mounted () {},
        watch: {},
        methods: {
            openChat(params) {
                const index = this.chats.findIndex(chat => {
                    return chat.uuid == params.uuid
                })
                if ( index == -1 ) {
                    this.chats.push(params)
                }
            },
            closeChat(uuid) {
                const index = this.chats.findIndex(chat => {
                    return chat.uuid == uuid
                })
                if (index >= 0) {
                    this.chats.splice(index, 1)
                }
            }
        }
  }
</script>
<style lang="scss" scoped>
    .chat-area {
        position: sticky;
        bottom: 0;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }
</style>
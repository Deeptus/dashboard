<template>
    <div class="chat-area">
        <chat :endpoint="endpoint" :uuid="chat" v-for="chat in chats" :key="chat" />
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
            openChat(uuid) {
                if (this.chats.indexOf(uuid) == -1) {
                    this.chats.push(uuid)
                }
            },
            closeChat(uuid) {
                const index = this.chats.indexOf(uuid)
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
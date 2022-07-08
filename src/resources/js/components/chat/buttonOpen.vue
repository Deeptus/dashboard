<template>
    <div @click="openChat()">
        <slot></slot>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            href: {
                type: String,
                default: ''
            }
        },
        components: {},
        data(){
            return{}
        },
        created() {},
        mounted () {},
        watch: {},
        methods: {
            openChat() {
                let formData = new FormData()
                axios.post(this.href, formData).then((response) => {
                    this.$root.openChat({ uuid: response.data.uuid, title: response.data.title })
                }).catch((error) => {

                })
            }
        }
  }
</script>
<style lang="scss" scoped>

</style>
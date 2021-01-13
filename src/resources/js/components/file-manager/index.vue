<template>
    <div class="file-manager" v-if="display == true">
        <div class="file-manager__overlay" @click="close()"></div>
        <div class="file-manager__modal">
            <div class="file-manager__header">
                <h3>Explorador de Archivos</h3>
                <div class="file-manager__close-btn" @click="close()">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="file-manager__tabs">
                <div class="file-manager__tab" :class="{'file-manager__tab--active': state == 'upload' }" @click="state = 'upload'">Subir archivos</div>
                <div class="file-manager__tab" :class="{'file-manager__tab--active': state == 'library' }" @click="state = 'library'">Biblioteca de medios</div>
            </div>
        </div>
    </div>
</template>
<script>
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: [],
        data(){
            return{
                message: 'data',
                display: false,
                state: 'library'
            }
        },
        created() {},
        mounted () {},
        watch: {},
        methods: {
            open: function(text) {
                document.body.style.overflow = 'hidden'
                this.display = true
                this.message = text
                return text
            },
            close() {
                document.body.style.overflow = 'auto'
                this.display = false
            }
        }
    }
</script>
<style lang="scss" scoped>
    .file-manager {
        position: fixed;
        z-index: 9;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        &__overlay {
            background-color: rgba(0, 0, 0, 0.3);
            position: absolute;
            width: 100%;
            height: 100%;
        }
        &__modal {
            position: relative;
            width: calc(100% - 60px);
            height: calc(100% - 60px);
            background-color: #FFF;
            padding: 15px;
            margin: 30px;
        }
        &__close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 1.5em;
            opacity: .7;
            cursor: pointer;
            transition: all .1s ease;
            &:hover {
                opacity: 1;
            }
        }
        &__tabs {
            border-bottom: 1px solid #CCC;
            width: calc(100% + 30px);
            margin: 15px -15px 15px -15px;
            padding: 0 15px;
            display: flex;
        }
        &__tab {
            padding: 7.5px;
            cursor: pointer;
            border: 1px solid #FFF;
            border-bottom: 1px solid #CCC;
            margin-bottom: -1px;
            &--active {
                border: 1px solid #CCC;
                border-bottom: 1px solid #FFF;
            }
        }
    }
</style>
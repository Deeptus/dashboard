<template>
    <div class="awesome-modal" v-if="display">
        <div class="awesome-modal__container container mt-5">
            <component :is="modal.component" :componentCallback="modal.componentCallback" v-bind="modal.props"></component>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            modal: {
                type: Object
            }
        },
        components: {},
        data(){
            return{
                display: false,
                props: {}
            }
        },
        created() {
            document.body.style.overflow = 'hidden';
            this.modal.componentCallback.promise.then(response => {
                // console.log(['desde el then del modal', response])
                this.closeModal()
            })
            this.modal.componentCallback.promise.catch(error => {
                // console.log(['desde el then del catch', error])
                this.closeModal()
            })
            this.display = true
            this.modal.promise = this.modal.componentCallback.promise
        },
        mounted: function () {},
        methods:{
            closeModal() {
                this.display = false
            }
        },
        watch: {},
        destroyed: function () {}
    }
</script>
<style lang="scss">
    .awesome-modal {
        background-color: rgba($color: #000000, $alpha: .4);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1059;
        display: flex;
        overflow: hidden;
        align-items: center;
        &__container {
            background-color: #ffffff;
            max-height: calc(100vh - 100px );
            margin: 0 auto !important;
            overflow-y: auto;
            padding: 0;
        }
        &__body {
            border-bottom: 1px solid #cbc8d0;
            border-top: 1px solid #cbc8d0;
            margin-bottom: 16px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        &__footer {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        &__header {
            font-size: 20px;
            font-weight: 600;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            &--nav-tabs {
                background-color: #ddd;
                padding-top: 15px;
            }
            .nav-link {
                font-size: 14px;
                line-height: 15px;
                &:hover, :focus {
                    border-color: transparent;
                    background-color: rgba(255, 255, 255, .3);
                }
            }
        }
        &__fixed-btns {
            position: sticky;
            width: 100%;
            height: 0;
            text-align: end;
            top: 0;
            opacity: .4;
            &:hover {
                opacity: 1;
            }
        }
    }
</style>
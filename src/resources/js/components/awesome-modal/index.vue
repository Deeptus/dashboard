<template>
    <div class="awesome-modal" v-if="display">
        <div class="awesome-modal__container container mt-5">
            <component :is="component" :componentCallback="componentCallback" v-bind="props"></component>
        </div>
    </div>
</template>
<script>
    /*
    Vue.mixin({
        created() {
        },
        methods: {
            openLoginFormModal() {
                this.$root.$refs.loginformmodal.openModal()
            }
        }
    })
    */
    const node = document.createElement('awesome-modal');
    node.setAttribute("ref", "awesome-modal");
    window.loginNode = node
    document.getElementById('app').appendChild(node)
    window.am = () => {
        return window.vueApp.$root.$refs['awesome-modal']
    }
    export default {
        props: ['action'],
        components: {},
        data(){
            return{
                display: false,
                props: {},
                component: Object,
                componentCallback: {}
            }
        },
        created() {
            // console.log('se registra modal')
        },
        mounted: function () {},
        methods:{
            openModal(component, props) {
                this.component = component
                this.props = props
                document.body.style.overflow = 'hidden';
                this.componentCallback.promise = new Promise((resolve, reject) => {
                    Object.assign(this.componentCallback, { resolve, reject })
                })
                this.componentCallback.promise.then(response => {
                    // console.log(['desde el then del modal', response])
                    this.closeModal()
                })
                this.componentCallback.promise.catch(error => {
                    // console.log(['desde el then del catch', error])
                    this.closeModal()
                })
                this.display = true
                return this.componentCallback.promise
            },
            closeModal() {
                this.display = false
                document.body.style.overflow = 'auto';
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
        z-index: 9999;
        display: flex;
        overflow: hidden;
        align-items: center;
        &__container {
            background-color: #ffffff;
            max-height: calc(100vh - 100px );
            margin: 0 auto !important;
            overflow-y: auto;
        }
        &__body {
            border-bottom: 1px solid #cbc8d0;
            border-top: 1px solid #cbc8d0;
            margin-top: 9px;
            margin-bottom: 16px;
        }
        &__footer {
            margin-bottom: 1.5rem;
        }
        &__header {
            margin-top: 1rem;
            font-size: 20px;
            font-weight: 600;
        }
    }
</style>
<template>
    <div>
        <modal v-for="(modal, key) in modals" :modal="modal" :key="key"></modal>
    </div>
</template>
<script>
    import modal from './modal.vue'
    const node = document.createElement('awesome-modal');
    node.setAttribute("ref", "awesome-modal");
    window.loginNode = node
    document.getElementById('app').appendChild(node)
    window.am = () => {
        return window.vueApp.$root.$refs['awesome-modal']
    }
    export default {
        props: ['action'],
        components: {
            modal
        },
        data(){
            return{
                modals: []
            }
        },
        watch: {
            modals: {
                deep: true,
                handler() {
                    if (this.modals.length == 0) {
                        document.body.style.overflow = 'auto';
                    }
                }
            }
        },
        mounted: function () {},
        methods:{
            openModal(component, props) {
                const e = { component, props, componentCallback: {} }
                e.componentCallback.promise = new Promise((resolve, reject) => {
                    Object.assign(e.componentCallback, { resolve, reject })
                })
                const key = this.modals.push(e)
                e.componentCallback.promise.then(response => {
                    this.modals.splice(key - 1, 1)
                })
                e.componentCallback.promise.catch(error => {
                    this.modals.splice(key - 1, 1)
                })
                return e.componentCallback.promise
            }
        }
    }
</script>
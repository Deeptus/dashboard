<template>
    <div @click="click">
        <slot v-if="displaySlot" name="add"></slot>
        <slot v-else name="remove"></slot>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        props: {
            ref_id: {},
            code: {},
            name: {},
            image_url: {},
            quantity: {},
            storage: {
                type: String,
                default: 'budget'
            }
        },
        components: {},
        data(){
            return{
                displaySlot: true
            }
        },
        created() {
            this.$nextTick(() => {
                this.cart  = JSON.parse(localStorage.getItem(this.storage))
                this.keys  = Object.keys(this.cart)
                this.items = Object.values(this.cart)
                if (this.keys.find(i => i == this.ref_id)) {
                    this.displaySlot = false
                }
            });
        },
        updated: function () {},
        methods: {
            click() {
                if (this.displaySlot) {
                    this.add()
                } else {
                    this.remove()
                }
            },
            add() {
                Swal.fire({
                    title: '¿ Desea añadir este producto ?',
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            html: "Producto <strong>" + this.name + "</strong> añadido al pedido",
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonText: "Ir a solicitar presupuesto",
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: "Seguir comprando",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let publicPath = document.head.querySelector('meta[name="public-path"]').content
                                window.location.href = publicPath + 'presupuesto'
                            }
                        })

                        let cart = JSON.parse(localStorage.getItem(this.storage))
                        if (!cart) {
                            cart = {}
                        }
                        cart[this.ref_id] = {
                            ref_id: this.ref_id,
                            code: this.code,
                            name: this.name,
                            image_url: this.image_url,
                            quantity: this.quantity
                        }
                        localStorage.setItem(this.storage, JSON.stringify(cart))
                        this.displaySlot = false
                    }
                })
            },
            remove() {
                Swal.fire({
                    title: '¿ Desea quitar este producto ?',
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Si, Quitar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            html: "Producto <strong>" + this.name + "</strong> quitado del pedido",
                            icon: "success",
                            confirmButtonText: "Listo",
                        })
                        let cart = JSON.parse(localStorage.getItem(this.storage))
                        if (!cart) {
                            cart = {}
                        }
                        delete cart[this.ref_id]
                        localStorage.setItem(this.storage, JSON.stringify(cart))
                        this.displaySlot = true
                    }
                })
            }
        }
  }
</script>
<style lang="scss" scoped>

</style>
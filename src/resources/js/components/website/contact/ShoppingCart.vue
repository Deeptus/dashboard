<template>
    <div class="row my-5">
        <div class="col-12">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">MARCA</th>
                        <th scope="col">CÓDIGO FKC</th>
                        <th scope="col">CÓDIGO OEM</th>
                        <th scope="col">PRECIO</th>
                        <th scope="col">CANTIDAD</th>
                        <th scope="col">TOTAL</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in form.cart" :key="key">
                        <td>
                        </td>
                        <td>{{ item.category }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.code }}</td>
                        <td>{{ item.price | toCurrency }}</td>
                        <td>
                            <input type="number" v-model="item.quantity" min="1" step="1" class="form-control text-center mx-auto" style="max-width: 100px;">
                        </td>
                        <td>{{ item.price * item.quantity | toCurrency }}</td>
                        <td>
                            <button class="btn btn-danger" @click="removeItem(key)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">VENTA SUJETA A DISPONIBILIDAD EN STOCK</div>
                <div class="card-body">
                    IMPORTANTE:
                    <ul>
                        <li>Los precios se encuentras empresados en PESOS.</li>
                        <li>El plazo de entrega de la mercaderia es de 24 horas.</li>
                    </ul>
                </div>
                <div class="card-header">VENTA SUJETA A DISPONIBILIDAD EN STOCK</div>
                <textarea class="form-control card-body" v-model="form.inputs.message.value" rows="3" placeholder="Días especiales para la entrega, cambios de domicilio, expresos, requerimientos especiales en la mercadería, etc."></textarea>
                <div class="card-header">SUBIR ARCHIVOS <small>({{ 3 - form.inputs.files.value.length }} archivos restastes)</small>
                    <button class="btn btn-primary" @click="selectFiles()" v-if="form.inputs.files.value.length < 3">
                        <i class="fas fa-plus"></i>
                        AÑADIR
                    </button>
                </div>
                <input type="file" style="display: none;" @change="uploadFiles()" multiple ref="files">
                <template v-if="form.inputs.files.value.length > 0">
                    <div class="card-body list-group">
                        <div class="list-group-item" v-for="(file, key) in form.inputs.files.value" :key="key">
                            {{ file.name }}
                            <button class="btn btn-danger" @click="removeFile(key)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="card-body">
                        No ha añaadido archivos.<br>Puede subir un maximo de 3 archivos.
                    </div>
                </template>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <table class="table table-striped align-middle table-total card-body mb-0">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>{{ subtotal() | toCurrency }}</td>
                        </tr>
                        <tr>
                            <td>Descuento del (10%)</td>
                            <td>{{ discount() | toCurrency }}</td>
                        </tr>
                        <tr>
                            <th>TOTAL (SIN IMPUESTOS)</th>
                            <th>{{ total() | toCurrency }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card" v-if="select_delivery_method">
                <div class="card-header">ENTREGA:</div>
                <div class="card-body">
                    <div class="form-check mb-3" v-for="(method, key) in deliveryMethods" :key="key">
                        <input
                            class="form-check-input"
                            type="radio"
                            :name="'delivery_method_' + key"
                            :id="'delivery_method_' + key"
                            :value="method.id"
                            :disabled="method.disabled"
                            :key="'delivery_method_' + key"
                            v-model="form.inputs.delivery_method.value"
                            >
                        <label class="form-check-label" :for="'delivery_method_' + key">
                            {{ method.name }}
                            <template v-if="method.description">
                                <br>
                                <small style="padding-left: 14px; display: block;">{{ method.description }}</small>
                            </template>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 mt-3">
            <a class="btn btn-outline-primary" href="">
                <i class="fas fa-shopping-cart"></i>
                <span>AGREGAR MAS PRODUCTOS</span>
            </a>
        </div>
        <div class="col-6 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" @click="submit()">
                <i class="fas fa-check"></i>
                <span>CONFIRMAR</span>
            </button>
        </div>
    </div>
</template>
<script>
    import Swal from 'sweetalert2'
    export default {
        props: {
            form: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        },
        components: {
            },
        data(){
            return {
                deliveryMethods: [
                    {
                        id: 1,
                        name: 'Retiro Cliente',
                        disabled: false,
                        description: null
                    },
                    {
                        id: 2,
                        name: 'Reparto FKC-FURCON',
                        disabled: false,
                        description: '* Para habilitar la opción Reparto FKC - FURCON, la compra deberá ser de mínimo $85,00'
                    },
                    {
                        id: 3,
                        name: 'Retito Transporte',
                        disabled: false,
                        description: null
                    }
                ],
                select_delivery_method: true
            }
        },
        created() {
            this.form.addInput({
                key: 'delivery_method',
                value: 1,
                label: ''
            })
            this.form.addInput({
                key: 'name',
                value: '',
                label: 'Nombre (*)',
                rules: {
                    // required: true,
                }
            })
            this.form.addInput({
                key: 'company',
                value: '',
                label: 'Empresa',
                rules: {
                    // required: false,
                }
            })
            this.form.addInput({
                key: 'phone',
                value: '',
                label: 'Teléfono (*)',
                rules: {
                    // required: true
                }
            })
            this.form.addInput({
                key: 'email',
                value: '',
                label: 'Email (*)',
                rules: {
                    // required: true,
                    // email: true
                }
            })
            this.form.addInput({
                key: 'message',
                value: '',
                label: 'Escriba acá su mensaje',
                rules: {
                    // required: true
                }
            })
            this.form.addInput({
                key: 'address',
                value: '',
                label: 'Dirección'
            })
            this.form.addInput({
                key: 'files',
                value: [],
                label: 'Archivos adjuntos',
                rules: {
                    // required: false
                }
            })
            this.$watch('form.inputs.delivery_method.value', (value) => {
                /*
                this.select_delivery_method = false
                setTimeout(() => {
                    this.select_delivery_method = true
                    this.$forceUpdate()
                    console.log(value)
                }, 1000)
                */
            })
            this.$nextTick(() => {
                let cart = localStorage.getItem('shopping-cart')
                if (cart) {
                    this.form.cart = Object.values(JSON.parse(cart)).filter((i) => Object.prototype.toString.call( i ) == '[object Object]')
                }
                if (typeof window.getSpsi === "function" && window.getSpsi()) {
                    this.form.inputs.name.value     = window.getSpsi().fullname
                    this.form.inputs.company.value  = window.getSpsi().business_name
                    this.form.inputs.phone.value    = window.getSpsi().phone
                    this.form.inputs.email.value    = window.getSpsi().email
                }
            });

        },
        methods: {
            selectFiles() {
                this.$refs.files.click()
            },
            uploadFiles() {
                // this.form.inputs.files.value.splice(0, this.form.inputs.files.value.length);
                let files = [...this.$refs.files.files]
                let max = 3;
                files.forEach(file => {
                    if (this.form.validateFile(file) && this.form.inputs.files.value.length < max) {
                        this.form.inputs.files.value.push(file)
                    }
                })
                this.$refs.files.value = ''
            },
            removeFile(key) {
                this.form.inputs.files.value.splice(key, 1)
            },
            subtotal() {
                let subtotal = 0
                this.form.cart.forEach(item => {
                    subtotal += item.price * item.quantity
                })
                return subtotal
            },
            discount() {
                return this.subtotal() * 0.1
            },
            total() {
                let subtotal = this.subtotal()
                if (subtotal >= 85) {
                    this.deliveryMethods[1].disabled = false
                } else {
                    this.deliveryMethods[1].disabled = true
                    if (this.form.inputs.delivery_method.value == 2) {
                        this.form.inputs.delivery_method.value = 1
                    }
                }
                return subtotal - this.discount()
            },
            submit() {
                /*Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Está seguro que desea confirmar la compra?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, confirmar!'
                }).then((result) => {
                    if (result.value) {*/
                        /////////////////////
                        this.form.formData.append('name',            this.form.inputs.name.value);
                        this.form.formData.append('email',           this.form.inputs.email.value);
                        this.form.formData.append('phone',           this.form.inputs.phone.value);
                        this.form.formData.append('address',         this.form.inputs.address.value);
                        this.form.formData.append('company',         this.form.inputs.company.value);
                        this.form.formData.append('message',         this.form.inputs.message.value);
                        this.form.formData.append('type',            'shopping-cart');
                        this.form.formData.append('cart',            JSON.stringify(this.form.cart));
                        if (this.form.inputs.files.value.length) {
                            this.form.inputs.files.value.forEach((file, key) => {
                                if (file && file instanceof File) {
                                    this.form.formData.append('files['+key+']', file);
                                }
                            })
                        }
                        this.form.submit()
                        console.log(this.form)
                        /////////////////////
                        /*Swal.fire(
                            'Confirmado!',
                            'La compra ha sido confirmada.',
                            'success'
                        )
                    }
                })*/
            },
            removeItem(key) {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Está seguro que desea eliminar el producto?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.form.cart.splice(key, 1)
                        localStorage.setItem('shopping-cart', JSON.stringify(this.form.cart))
                        Swal.fire(
                            'Eliminado!',
                            'El producto ha sido eliminado.',
                            'success'
                        )
                    }
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
.thumbnail-product {
    width: 50px;
    height: 50px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: auto;
}
table {
    // table-layout: fixed;
    text-align: center;
}
thead {
    &, th {
        background-color: var(--secondary);
        letter-spacing: 0.14px;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: 300;
    }
}
a.page-link {
    min-width: 50px;
    text-align: center;
}
li.page-item {
    white-space: nowrap;
}
.form-control.card-body {
    border-radius: 0;
    outline: none;
    border: none;
}
.card-header {
    position: relative;
    color: #212121;
    padding: 16px 27px;
    font-size: 14px;
    font-weight: 300;
    & .btn {
        position: absolute;
        right: 0;
        top: 0;
        border-radius: 0;
        bottom: 0;
        font-weight: 300;
        font-size: 14px;
    }
}
.card-body.list-group {
    padding: 0;
    border-radius: 0;
    border: none;

}
.list-group-item {
    position: relative;
    overflow: hidden;
    white-space: nowrap;
    .btn {
        position: absolute;
        right: 0;
        top: 0;
        border-radius: 0;
        bottom: 0;
        font-weight: 300;
        font-size: 14px;
    }
}
.table-total {
    table-layout: fixed;
    th, td {
        padding: 20px 20px;
    }
    th {
        font-size: 17px;
        color: #000 !important;
        font-weight: 700;
    }
}
</style>
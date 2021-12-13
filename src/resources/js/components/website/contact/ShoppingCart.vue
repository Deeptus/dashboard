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
                            <div class="thumbnail-product" :style="'background-image: url(\'' + item.image_url + '\');'"></div>
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
                <textarea class="form-control card-body" v-model="form.notes" rows="3" placeholder="Días especiales para la entrega, cambios de domicilio, expresos, requerimientos especiales en la mercadería, etc."></textarea>
                <div class="card-header">SUBIR ARCHIVOS <button class="btn btn-primary" @click="selectFiles()"><i class="fas fa-plus"></i> AÑADIR</button></div>
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
                        No ha añaadido archivos.
                    </div>
                </template>
            </div>
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
            return {}
        },
        created() {
            this.$nextTick(() => {
                console.log(this.form)
                let cart = localStorage.getItem('shopping-cart')
                if (cart) {
                    this.form.cart = Object.values(JSON.parse(cart))
                }
            });
        },
        methods: {
            selectFiles() {
                this.$refs.files.click()
            },
            uploadFiles() {
                this.form.inputs.files.value = this.$refs.files.files
            },
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
</style>
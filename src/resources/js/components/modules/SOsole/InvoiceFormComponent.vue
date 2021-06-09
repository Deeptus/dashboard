<template>
<div class="row">
    <div class="col s12">
        <div class="row justify-content-center" v-if="loaded == 0">
            <h3><center><i class="fas fa-sync fa-spin"></i><br>Cargando</center></h3>
        </div>
        <div class="row justify-content-center" v-if="loaded == 2">
            <h3><center><i class="fas fa-sync fa-spin"></i><br>Guardando</center></h3>
        </div>
        <div class="row justify-content-center" v-if="loaded == 3">
            <div class="col-xl-12 col-md-12 mb-12">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mensaje</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Se ha registrado una <strong>Factura</strong> con éxito
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="loaded == 1">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del Cliente</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="company">Cliente</label>
                                <typeahead-client :model.sync="client" :data="clients"></typeahead-client>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Persona de Contacto</label>
                                <input type="text" class="form-control" id="name" name="name" v-model="client.name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cuit">CUIT</label>
                                <input type="text" class="form-control" id="cuit" name="cuit" v-model="client.cuit">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Correo Electrónico</label>
                                <input type="text" class="form-control" id="email" name="email" v-model="client.email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Telefono</label>
                                <input type="text" class="form-control" id="phone" name="phone" v-model="client.phone">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" id="address" name="address" v-model="client.address">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Descripción / Texto Alternativo / Comentarios</label>
                                <textarea class="form-control" id="description" name="description" v-model="client.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Items a Facturar</h6>
                    </div>
                    <div class="card-body">
                        <div class="row" v-for="(item,index) in items" :key="index">
                            <div class="form-group col-md-4" v-if="reloadProductSearch">
                                <label :for="'description'+index">Descripción</label>
                                <typeahead :model.sync="item" :index="index" :data="products"></typeahead>
                            </div>
                            <div class="form-group col-md-2">
                                <label :for="'cant'+index">Cantidad</label>
                                <input type="text" v-model="item.cant" class="form-control" :id="'cant'+index" name="cant" value="">
                            </div>
                            <div class="form-group col-md-2">
                                <label :for="'unit_price'+index">Precio</label>
                                <input type="text" v-model="item.price" class="form-control" :id="'unit_price'+index" name="unit_price" value="">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Importe</label>
                                <div class="form-control">{{ item.price*item.cant }}</div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button @click="deleteItem(index)" type="button" class="btn btn-danger rounded-circle"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 d-flex align-items-center justify-content-center">
                                    <button @click="addItem()" type="button" class="btn btn-danger rounded-pill mb-2">
                                        <i class="fas fa-plus"></i>
                                        Añadir item
                                    </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 offset-md-6 d-flex align-items-center justify-content-end">
                                <strong>Subtotal:</strong>
                            </div>
                            <div class="col-md-3"><div class="form-control">{{ getSubTotal() }}</div></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 offset-md-6 d-flex align-items-center justify-content-end">
                                <strong>IVA (21%):</strong>
                            </div>
                            <div class="col-md-3"><div class="form-control">{{ getIva() }}</div></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 offset-md-6 d-flex align-items-center justify-content-end">
                                <strong>Total:</strong>
                            </div>
                            <div class="col-md-3"><div class="form-control">{{ getTotal() }}</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="loaded == 1">
            <div class="col-xl-12 col-lg-12 d-sm-flex align-items-center justify-content-between">
                <a :href="urlBack" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                    <i class="fas fa-step-backward fa-sm text-white-50"></i>
                    Volver Atras
                </a>

                <button type="button" @click="postForm()" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm">
                    <i class="fas fa-save fa-sm text-white-50"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import Typeahead from './TypeaheadComponent.vue'
    import TypeaheadClient from './TypeaheadClientComponent.vue'
    export default {
        components: {
            Typeahead,
            TypeaheadClient
        },
        props: {
            urlData: '',
            urlBack: '',
            urlAction: '',
        },
        data(){
            return{
                query: '',
                reloadProductSearch: true,
                userRepositories: {},
                client: {
                    id: null,
                    company: '',
                    name: '',
                    address: null,
                    cuit: null,
                    phone: null,
                    email: null,
                    description: null,
                },
                clients: [],
                products: [],
                items: [],
                loaded: 0
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.clients  = response.data.cliente
                    this.products = response.data.product
                    this.loaded   = 1
                });
            });
        },
        methods: {
            watchItems() {
                return this.items.length
            },
            postForm() {
                this.loaded = 2
                axios.post(this.urlAction, {
                    client: this.client,
                    items: this.items,
                }).then((response) => {
                    this.loaded = 3
                    var self = this
                    setTimeout(function(){
                        window.location.href = self.urlBack
                    }, 1000);
                });
            },
            searchUsers(newQuery) {
                //console.log(newQuery)
            },
            hit() {
                //console.log('hit')
            },
            addToCount(data) {
                //console.log(data)
            },
            deleteItem: function (index) {
                //console.log(this.items[index])
                this.items.splice(index, 1);
                //console.log(this.items)
                //console.log(index)
                // this.piezeTotales.splice(index, 1);
                // if (this.material.length === 0)
                //     this.addMaterial()
            },
            addItem: function (index) {
                this.items.push({
                    id: null,
                    description: '',
                    cant: null,
                    price: 0
                })
                //console.log(this.items)
            },
            getSubTotal: function () {
                var self = this
                var subTotal = 0
                Object.keys(this.items).forEach(function(key){
                    subTotal += self.items[key].cant * self.items[key].price
                })
                return subTotal
            },
            getIva: function () {
                var self = this
                var subTotal = 0
                Object.keys(this.items).forEach(function(key){
                    subTotal += self.items[key].cant * self.items[key].price
                })
                return subTotal * 0.21
            },
            getTotal: function () {
                var self = this
                var subTotal = 0
                Object.keys(this.items).forEach(function(key){
                    subTotal += self.items[key].cant * self.items[key].price
                })
                return subTotal * 1.21
            },
        },
        watch: {
            items: _.debounce(function(newQuery) {
                this.reloadProductSearch=false
                var self = this;
                setTimeout(function(){ self.reloadProductSearch=true }, 1);
            }, 1)
        },
        filters: {
            stringify(value) {
                return JSON.stringify(value, null, 2)
            }
      },
  }
</script>

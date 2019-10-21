<template>
    <div class="container-fluid" :style="formDisabled()">
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
                                Se ha guardado el <strong>Contenido</strong> con éxito
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
        <div class="row justify-content-center" v-if="loaded == 1">
            <div class="col-md-12 my-5">
                <!--------PRESUPUESTO----------->
                <div class="card mt-5">
                    <div class="card-header">Presupuesto</div>
                    <form class="card-body row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha De Elaboración</label>
                                <!-- <input type="date" v-model="presupuesto.fecha" class="form-control col-md-9" placeholder=""> -->
                                <div class="form-control disabled">{{ presupuesto.fecha }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número Del Presupuesto</label>
                                <div class="form-control disabled">{{ presupuesto.numeropresupuesto }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>N° De Proyecto Asociado</label>
                                <input type="text" v-model="presupuesto.numeroproyecto" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lista De Precios</label>
                                <select class="form-control" v-model="list_price_id" disabled="">
                                    <option v-for="item in list_price" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="false">
                            <div class="form-group">
                                <label>IVA Aplicado</label>
                                <input type="text" v-model="$root.iva" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4" v-if="false">
                            <div class="form-group">
                                <label>MarkUP</label>
                                <input type="text" v-model="$root.markup" class="form-control" placeholder="">
                            </div>
                        </div>
                    </form>
                </div>
                <!--------CLIENTES----------->
                <clientes :cliente="cliente" :localidades="localidades"></clientes>

                <!--------ITEM----------->
                <Item
                    :cliente="cliente"
                    :items="items"
                    :superficies="superficies"
                    :materiales="materiales"
                    :adicionales="adicionales"
                    :terminaciones="terminaciones"
                    :aplicados="aplicados"
                ></Item>

                <!--------TRABAJOS DE OBRAS GLOBALES----------->
                <trabajos-globales
                    :items="items"
                    :config="config"
                    :tienda="tienda"
                    :cliente="cliente"
                    :globales="globales"
                    :localidades="localidades"
                    :trabajosglobales="trabajosglobales"
                ></trabajos-globales>

                <!--------PRESUPUESTO DE TOTAL----------->
                <div class="row" v-if="displayPrice()">
                    <div class="col-md-6 offset-md-6">
                        <div class="card-header bg-success text-white">Presupuesto Total </div>
                        <div class="card-body" style="background-color: #CDCDCD">
                            <div class="d-flex justify-content-between" v-for="item in items">
                                <p class="mb-1">Item: {{ item.item }}</p>
                                <p class="mb-1">{{ calcIvaMarkup(totalPerItem(item)) | toCurrency }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-1">Trabajos globales</p>
                                <p class="mb-1">{{ calcIvaMarkup(totalTrabGlobales()) | toCurrency }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="font-weight-bold">TOTAL PRESUPUESTO</p>
                                <p class="mb-1">{{ calcIvaMarkup(totalTotal()) | toCurrency }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--------OBSERVACIONES----------->
                <div class="card mt-5">
                    <div class="card-header">Observaciones</div>
                    <form class="card-body row">
                        <div class="col-md-12">
                            <div v-html="config['cotizador-observaciones-1']"></div>
                            <div class="row">
                                <div class="col-md-12 form-group mt-5">
                                    <label>Descripción</label>
                                    <textarea class="form-control" v-model="observaciones.descripcion" placeholder="Mensaje..." rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row" v-if="false">
                                <label class="col-md-1">Alcances del presupuesto</label>
                                <textarea class="form-control-file col-md-11" v-model="observaciones.alcancepresupuesto" placeholder="Mensaje..." rows="3"></textarea>
                            </div>
                            <div v-html="config['cotizador-observaciones-tienda-1']"></div>
                        </div>
                    </form>
                </div>

                <!--------CLAUSULAS ECONOMICAS----------->
                <div class="card mt-5">
                    <div class="card-header">Cláusulas económicas</div>
                    <form class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-1">Forma de pago</label>
                                <input type="text" v-model="clausulas.formaspago" class="form-control col-md-11" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-1">Medios de pago</label>
                                <input type="text" v-model="clausulas.mediospago" class="form-control col-md-11" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-1">Validez de la oferta</label>
                                <input type="text" v-model="clausulas.validezoferta" class="form-control col-md-11" placeholder="">
                            </div>
                        </div>
                    </form>
                </div>

                <!--------PLANOS Y ORDEN DE COMPRAS----------->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-5 mb-5">
                            <div class="card-header">Planos</div>
                            <form class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-4">Añadir plano</label>
                                        <input type="file" class="form-control-file col-md-8">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- <div class="col-md-6" v-if="false">
                        <div class="card mt-5">
                            <div class="card-header">Orden de Compra</div>
                            <form class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-4">Adjuntar orden de Compra</label>
                                        <input type="file" @change="onFileChange" class="form-control-file col-md-8"  >
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4">Generar orden de compra</label>
                                        <a href="" class="btn btn-success">Orden Automática</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->
                </div>


                <button
                    @click="guardarPresupuesto"
                    class="btn btn-lg"
                    style="border: 1px solid #EE4996; color: #EE4996">
                    Guardar Presupuesto
                </button>
                <button
                    type="button"
                    class="btn btn-lg text-white"
                    data-toggle="modal"
                    data-target="#confirmarPedidoStep1"
                    style="background-color: #EE4996; float: right;">
                    Confirmar Pedido
                </button>
                <div class="modal fade" id="confirmarPedidoStep1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Esta seguro en volver este presupuesto en pedido
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal">
                                    Cancelar
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-dismiss="modal"
                                    @click="confirmarPedido()">
                                    Confirmar pedido
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmarPedidoStep2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Area en Construcción</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img :src="imgConstruccion()">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Clientes from './ClientesComponent.vue'
    import Material from './MaterialComponent.vue'
    import Terminaciones from './TerminacionesComponent.vue'
    import TrabajosAplicados from './TrabajosAplicadosComponent.vue'
    import TrabajosEspeciales from './TrabajosEspecialesComponent.vue'
    import TrabajosGlobales from './TrabajosGlobalesComponent.vue'
    import Item from './ItemComponent.vue'
    import moment from 'moment'

    export default {
        components: {
            Material,
            Terminaciones,
            TrabajosAplicados,
            TrabajosEspeciales,
            TrabajosGlobales,
            Clientes,
            Item,
        },
        props: {
            urlData: '',
            urlBack: '',
            urlAction: '',
            formName: '',
        },
        data() {
            return{
                superficies: Array,
                materiales: Array,
                localidades: Array,
                adicionales: Array,
                terminaciones: Array,
                aplicados: Array,
                globales: Array,
                tienda: {},
                config: {},
                list_price: Array,
                list_price_id: 0,
                convert_to_pedido: 0,
                presupuesto: {
                    fecha:  '',
                    numeropresupuesto: '',
                    numeroproyecto: '',
                },
                cliente: {
                    nombre: '',
                    apellido: '',
                    direccion: '',
                    localidad_id: 0,
                    telefono_1: '',
                    telefono_2: '',
                    encargado: '',
                    encargado_telefono: '',
                    horasentrega: '',
                    diasentrega: [],
                    restricciones:{},
                },
                clienteOLD: {},
                items:[
                    {
                        item:'',
                        material:[
                            {
                                pieza: 0,
                                material: 0,
                                existencia: '',
                                observaciones: '',
                                largometros: 0,
                                anchometros: 0,
                                metroscuadrados: '',
                                preciomaterial: '',
                                adicional: 1,
                                precioadicional: '',
                                monto: '',
                            }
                        ],
                        terminaciones:[
                            {
                                terminacion:'',
                                largo:'',
                                preciomaterial:'',
                                monto:''
                            }
                        ],
                        trabajosaplicados:[
                            {
                                trabajo: '',
                                unidad: '',
                                cantidad: '',
                                preciounitario: '',
                                monto: '',
                            }
                        ],
                        trabajosespeciales:[
                            {
                                trabajo: '',
                                monto: '',
                            }
                        ],
                        totales:{
                            material: {
                                price: 0,
                                m2:    0,
                            },
                            terminacion: 0,
                            aplicado: 0,
                            especial: 0,
                        },
                    }
                ],
                trabajosglobales:[
                    {
                        trabajo: '',
                        monto: '',
                    }
                ],
                observaciones:{
                    descripcion:'',
                    alcancepresupuesto:'',
                },
                clausulas:{
                    formaspago:'',
                    mediospago:'',
                    validezoferta:'',
                },
                url : document.__API_URL,
                allData: [],
                loaded: 0,
                firstStart: 1
            }
        },
        // watch: {
        //     cliente: {
        //         handler(val){
        //             if (this.firstStart == 1) {
        //                 console.log('si')
        //                 this.clienteOLD = JSON.parse(JSON.stringify(this.cliente))
        //                 this.firstStart = 0
        //             } else {
        //                 console.log('no')
        //                 console.log(this.cliente)
        //                 if (JSON.stringify(this.cliente) != JSON.stringify(this.clienteOLD)) {
        //                     this.cliente = JSON.parse(JSON.stringify(this.clienteOLD))
        //                 }
        //             }
        //         },
        //         deep: true
        //     }
        // },
        // watch: {
        //     items: {
        //         handler(val){
        //             if (this.loaded == 1) {
        //                 console.log('hola')
        //             }
        //         },
        //         deep: true
        //     }
        // },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.superficies   = response.data.superficies
                    this.localidades   = response.data.localidades
                    this.materiales    = response.data.materiales
                    this.adicionales   = response.data.adicionales
                    this.terminaciones = response.data.terminaciones
                    this.aplicados     = response.data.aplicados
                    this.globales      = response.data.globales
                    this.tienda        = response.data.tienda
                    this.config        = response.data.config
                    this.list_price    = response.data.list_price
                    // Data
                    if (!Array.isArray(response.data.data)) {
                        // console.log(response.data.data.length)
                        this.presupuesto      = response.data.data.presupuesto
                        this.cliente          = response.data.data.cliente
                        this.items            = response.data.data.items
                        this.trabajosglobales = response.data.data.trabajosglobales
                        this.observaciones    = response.data.data.observaciones
                        this.clausulas        = response.data.data.clausulas
                    }
                    //
                    this.list_price_id     = response.data.list_price_select
                    this.$root.actions     = response.data.actions
                    this.$root.iva         = response.data.iva
                    this.$root.markup      = response.data.tienda.tienda.markup
                    this.presupuesto.fecha = this.dateNow()
                    this.loaded            = 1
                });
            });
        },
        mounted() {
        },
        updated: function(){
            this.$nextTick(function(){
                console.log(this.$root.targetFocus)
                if (this.$root.targetFocus != null) {
                    document.getElementById(this.$root.targetFocus).focus()
                    this.$root.targetFocus = null
                }
            });
        },
        methods:{
            imgConstruccion() {
                return document.__API_URL+'/images/seccion-en-construccion.png'
            },
            dateNow() {
                Date.prototype.toDateInputValue = (function() {
                    var local = new Date(this)
                    local.setMinutes(this.getMinutes() - this.getTimezoneOffset())
                    return local.toJSON().slice(0,10)
                })
                return new Date().toDateInputValue()
            },
            totalPerItem(item) {
                var total = 0
                Object.keys(item.totales).forEach(function (key) {
                    if (key == "material") {
                        total += parseFloat(item.totales[key].price)
                    } else {
                        total += parseFloat(item.totales[key])
                    }
                })
                return total
            },
            totalTrabGlobales() {
                var self = this
                var total = 0
                Object.keys(self.trabajosglobales).forEach(function (key) {
                    total += parseFloat(self.trabajosglobales[key].monto)
                })
                return total
            },
            totalTotal() {
                var total = 0
                var self = this
                this.items.forEach(function(item) {
                    total += self.totalPerItem(item)
                });
                total += self.totalTrabGlobales()
                return total
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            guardarPresupuesto(){
                var self = this
                this.loaded = 1
                let presupuesto = {
                    list_price_id: this.list_price_id,
                    convert_to_pedido: this.convert_to_pedido,
                    presupuesto: this.presupuesto,
                    cliente: this.cliente,
                    items: this.items,
                    trabajosglobales: this.trabajosglobales,
                    observaciones: this.observaciones,
                    clausulas: this.clausulas,
                };
                var formData = new FormData();
                formData.append('presupuesto', JSON.stringify(presupuesto));
                axios.post(this.urlAction, formData).then((response) => {
                    this.loaded = 3
                    setTimeout(function(){
                        //self.loaded = 1
                        window.location.href = self.urlBack
                    }, 1000);
                }).catch((error) => {
                    alert('error');
                    this.loaded = 1
                })
            },
            confirmarPedido() {
                this.convert_to_pedido = 1
                this.guardarPresupuesto()
            }
        },
    }
</script>
<style type="text/css">
.form-control.disabled, .form-control:disabled, .form-control[readonly] {
    background-color: #F9F8FC;
    opacity: 0.6;
}
</style>

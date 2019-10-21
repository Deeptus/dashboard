<template>
    <div class=" ">
        <div class="card-header">Trabajos Aplicados {{item}}</div>
        <div class="card-body">
            <div class="row" v-for="(item,index) in itemtrabajosaplicados" :key="index">
                <div class="form-group col-md-5">
                    <label>Trabajos</label>
                    <select v-model="item.trabajo" class="form-control" :id="'trabajoaplicado-'+index">
                        <option value="" disable selected>Seleccionar</option>
                        <option
                        :value="trabajo.id"
                        v-for="(trabajo, index) in datatrabajosaplicados"
                        >
                            {{ trabajo.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Unidad</label>
                            <div class="form-control">{{ trabajoUnidad(item) }}</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Cantidad</label>
                            <input type="text" v-model="item.cantidad" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row" v-if="displayPrice()">
                        <div class="form-group col-md-6">
                            <label>Precio Unitario</label>
                            <div class="form-control">{{ trabajoPrice(item) | toCurrency }}</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Monto en $</label>
                            <div class="form-control">{{ trabajoTotal(item) | toCurrency }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 form-group d-flex align-items-end justify-content-center">
                    <button @click.prevent="deleteTrabajosAplicados(index)" class="btn btn-danger">X</button>
                </div>
            </div>
            <div class="text-right" v-if="displayPrice()">
                <p><b>Subtotal Trabajos Aplicados: $ {{ trabajosTotal() | toCurrency }}</b></p>
                <button @click="addTrabajosAplicados" class="btn btn-success">Agregar</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['itemtrabajosaplicados','item', 'datatrabajosaplicados', 'total'],
        data(){
            return{

            }
        },
        mounted() {
            //console.log('Component mounted.')
        },
        methods:{
            trabajosTotal: function (){
                var total = 0
                this.itemtrabajosaplicados.forEach(function(item, key){
                    total += item.monto
                })
                this.total.aplicado = total
                return this.calcIvaMarkup(total)
            },
            trabajoPrice: function (item) {
                if (item.trabajo != "")
                    return this.calcIvaMarkup(this.datatrabajosaplicados[item.trabajo-1].display_price)
            },
            trabajoUnidad: function (item) {
                if (item.trabajo != "")
                    return this.datatrabajosaplicados[item.trabajo-1].unit
            },
            trabajoTotal: function (item) {
                if (item.trabajo != "") {
                    item.monto = this.datatrabajosaplicados[item.trabajo-1].display_price * item.cantidad
                    return this.trabajoPrice(item) * item.cantidad
                }
            },
            addTrabajosAplicados: function () {
                this.itemtrabajosaplicados.push({
                    trabajo: '',
                    unidad: '',
                    cantidad: '',
                    preciounitario: '',
                    monto: '',
                });
                this.$root.targetFocus = 'trabajoaplicado-'+(this.itemtrabajosaplicados.length-1);
            },
            deleteTrabajosAplicados: function (index) {
                this.itemtrabajosaplicados.splice(index, 1);
                if (this.itemtrabajosaplicados.length === 0)
                    this.addTrabajosAplicados()
            }
        },
    }
</script>

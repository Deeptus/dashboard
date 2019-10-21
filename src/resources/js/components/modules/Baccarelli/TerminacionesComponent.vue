<template>
    <div class=" ">
        <div class="card-header">Terminaciones de borde {{item}}</div>
        <div class="card-body">
            <div class="row" v-for="(item,index) in itemterminaciones" :key="index">
                <div class="form-group col-md-5">
                    <label>Terminacion de Borde</label>
                    <select v-model="item.terminacion" class="form-control" :id="'terminacion-'+index">
                        <option value="" disable selected>Seleccionar</option>
                        <option
                        :value="terminacion.id"
                        v-for="(terminacion, index) in dataterminaciones"
                        >
                            {{ terminacion.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Largo</label>
                    <input type="text" v-model="item.largo" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label v-if="displayPrice()">Precio de Material</label>
                    <div class="form-control" v-if="displayPrice()">{{ materialPrice(item) | toCurrency }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label v-if="displayPrice()">Monto $</label>
                    <div class="form-control" v-if="displayPrice()">{{ materialTotal(item) | toCurrency }}</div>
                </div>
                <div class="col-md-1 form-group d-flex align-items-end justify-content-center">
                    <button @click.prevent="deleteTerminaciones(index)" class="btn btn-danger">X</button>
                </div>
            </div>
            <div class="text-right" v-if="displayPrice()">
                <p><b>Subtotal Terminación: $ {{ materialesTotal() | toCurrency }}</b></p>
                <button @click="addTerminaciones" class="btn btn-success">Agregar</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item', 'itemterminaciones', 'dataterminaciones', 'total'],
        data(){
            return{

            }
        },
        mounted() {
        },
        methods:{
            materialesTotal: function (){
                var total = 0
                this.itemterminaciones.forEach(function(item, key){
                    total += item.monto
                })
                this.total.terminacion = total
                return this.calcIvaMarkup(total)
            },
            materialPrice: function (item) {
                if (item.terminacion != "")
                    return this.calcIvaMarkup(this.dataterminaciones[item.terminacion-1].display_price)
            },
            materialTotal: function (item) {
                if (item.terminacion != "") {
                    item.monto = this.dataterminaciones[item.terminacion-1].display_price * item.largo
                    return this.materialPrice(item) * item.largo
                }
            },
            addTerminaciones: function () {
                this.itemterminaciones.push({
                    terminacion:'',
                    largo:'',
                    preciomaterial:'',
                    monto:''
                });
                this.$root.targetFocus = 'terminacion-'+(this.itemterminaciones.length-1);
            },
            deleteTerminaciones: function (index) {
                this.itemterminaciones.splice(index, 1);
                if (this.itemterminaciones.length === 0)
                    this.addTerminaciones()
            }
        },
    }
</script>

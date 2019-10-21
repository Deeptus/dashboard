<template>
    <div class=" ">
        <div class="card-header">Trabajos Especiales {{item}}</div>
        <div class="card-body">
            <div class="row" v-for="(item,index) in trabajosespeciales" v-bind:key="index">
                <div class="form-group col-md-7">
                    <label>Descripción de trabajos especiales</label>
                    <input type="text" v-model="item.trabajo" class="form-control" placeholder="Describir trabajo no estipulado en ningún otro campo necesario para la realización de la obra" :id="'trabajoespecial-'+index">
                </div>
                <div class="form-group col-md-4" v-if="priceTbjEsp()">
                    <label>Monto en $</label>
                    <input type="text" v-model="item.monto" class="form-control">
                </div>
                <div class="form-group col-md-4" v-else>
                    <label v-if="displayPrice()">Monto en $</label>
                    <div class="form-control">{{ calcIvaMarkup(item.monto) }}</div>
                </div>
                <div class="col-md-1 form-group d-flex align-items-end justify-content-center">
                    <button @click.prevent="deleteTrabajosEspeciales(index)" class="btn btn-danger">X</button>
                </div>
            </div>
            <div class="text-right" v-if="displayPrice()">
                <p><b>Subtotal Trabajos Especial: $ {{ calcIvaMarkup(trabajosTotal()) | toCurrency }}</b></p>
                <button @click="addTrabajosEspeciales" class="btn btn-success">Agregar</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['trabajosespeciales','item', 'total'],
        data(){
            return{

            }
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
            trabajosTotal: function (){
                var total = 0
                this.trabajosespeciales.forEach(function(item, key){
                    total += parseFloat(item.monto?item.monto:0)
                })
                this.total.especial = total
                return this.calcIvaMarkup(total)
            },
            addTrabajosEspeciales: function () {
                this.trabajosespeciales.push({
                    trabajo: '',
                    monto: '',
                });
                this.$root.targetFocus = 'trabajoespecial-'+(this.trabajosespeciales.length-1);
            },
            deleteTrabajosEspeciales: function (index) {
                this.trabajosespeciales.splice(index, 1);
                if (this.trabajosespeciales.length === 0)
                    this.addTrabajosEspeciales()

            }
        },
    }
</script>

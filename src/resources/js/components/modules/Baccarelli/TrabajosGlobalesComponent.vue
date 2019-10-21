<template>
    <div class=" ">
        <div class="card mt-5">
            <div class="card-header">Trabajos de Obras Globales</div>
            <div class="card-body">
                <div class="row" v-if="display" v-for="(item,index) in trabajosglobales" v-bind:key="index">
                    <div class="form-group col-md-7">
                        <label>Trabajos globales</label>
                        <select v-model="item.trabajo" @change="changeTrabajo(item)" class="form-control" :id="'trabajoglobal-'+index">
                            <option value="" disable selected>Seleccionar</option>
                            <option value="flete">Flete</option>
                            <option value="flete_colocacion">Flete y Colocación</option>
                            <option value="medicion">Medición</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label v-if="displayPrice()">Monto en $</label>
                        <div class="form-control" v-if="displayPrice()">{{ priceTrabajo(item) | toCurrency }}</div>
                    </div>
                    <div class="col-md-1 form-group d-flex align-items-end justify-content-center">
                        <button @click.prevent="deleteTrabajosGlobales(index)" class="btn btn-danger">X</button>
                    </div>
                </div>
                <div class="text-right" v-if="displayPrice()">
                    <p><b>Total Trabajos Globales: $ {{ trabajosTotal() | toCurrency }}</b></p>
                    <button @click="addTrabajosGlobales" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['config', 'items', 'tienda', 'cliente', 'globales', 'localidades', 'trabajosglobales'],
        data(){
            return{
                display: 1,
            }
        },
        mounted() {
            //console.log('Component mounted.')
        },
        methods: {
            trabajosTotal: function (){
                var total = 0
                this.trabajosglobales.forEach(function(item, key){
                    total += item.monto
                })
                return this.calcIvaMarkup(total)
            },
            calculeFlete(horas){
                let fot = Object.values(this.globales).find(function(element) {
                    return element.code == 'FOT';
                })
                return fot.display_price * horas
            },
            calculeFleteColocacion(horas){
                let acm = Object.values(this.globales).find(function(element) {
                    return element.code == 'ACM';
                })
                let fot = Object.values(this.globales).find(function(element) {
                    return element.code == 'FOT';
                })
                let valorNivel = 0
                if (horas>6) {
                    valorNivel = this.tienda.nivel.tiempo_60
                }
                if (horas<=6) {
                    valorNivel = this.tienda.nivel.tiempo_46
                }
                if (horas<4) {
                    valorNivel = this.tienda.nivel.tiempo_04
                }

                var tiempo = (valorNivel * horas) + horas
                var totalM2 = 0
                this.items.forEach(function(item) {
                    totalM2 += item.totales.material.m2
                });
                let minimo = this.config['cotizador-m2-min']
                // Si los metros cuadrados minimos es mayor a los metros cuadrados seleccionados usa los minimos
                let m2 = (minimo > totalM2) ? minimo : totalM2

                let totalMinimo = (tiempo * fot.display_price) + (m2 * acm.display_price)
                // console.log([tiempo, fot.display_price, m2, acm.display_price])
                return totalMinimo
            },
            calculeMedicion(horas){
                let momohf = Object.values(this.globales).find(function(element) {
                    return element.code == 'MOMOHF';
                })
                return momohf.display_price * horas
            },
            changeTrabajo(item) {
                var self = this
                if (!this.cliente.localidad_id) {
                    alert('Debe seleccionar una localidad')
                    return false;
                }
                let localidad = this.localidades.find(function(element) {
                    return element.id == self.cliente.localidad_id;
                });
                let horas = localidad.horas + localidad.horas_peaje;
                if (item.trabajo == 'flete') {
                    return item.monto = this.calculeFlete(horas);
                }
                if (item.trabajo == 'flete_colocacion') {
                    return item.monto = this.calculeFleteColocacion(horas);
                }
                if (item.trabajo == 'medicion') {
                    return item.monto = this.calculeMedicion(horas);
                }
                return item.monto = '';
            },
            priceTrabajo(item) {
                if (item.trabajo) {
                    return this.calcIvaMarkup(this.changeTrabajo(item))
                }
                return ''
            },
            addTrabajosGlobales: function () {
                this.trabajosglobales.push({
                    trabajo: '',
                    monto: '',
                });
                this.$root.targetFocus = 'trabajoglobal-'+(this.trabajosglobales.length-1);
            },
            deleteTrabajosGlobales: function (index) {
                this.trabajosglobales.splice(index, 1);
                if (this.trabajosglobales.length === 0)
                    this.addTrabajosGlobales()
            }
        },
    }
</script>

<template>
    <div class="row">
        <div class="col-md-6 offset-md-6">
            <div class="card-header text-white" style="background-color: #8592A6;">Presupuesto de: <strong>{{ item }}</strong></div>
            <div class="card-body" style="background-color: #CDCDCD">
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Materiales</p>
                    <p class="mb-1">{{ calcIvaMarkup(this.total.material.price) | toCurrency }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Terminaciones de borde</p>
                    <p class="mb-1">{{ calcIvaMarkup(this.total.terminacion) | toCurrency }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Trabajos aplicados</p>
                    <p class="mb-1">{{ calcIvaMarkup(this.total.aplicado) | toCurrency }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-1">Trabajos especiales</p>
                    <p class="mb-1">{{ calcIvaMarkup(this.total.especial) | toCurrency }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="font-weight-bold">SUBTOTAL ITEM</p>
                    <p class="mb-1">{{ calcIvaMarkup(totalSum()) | toCurrency }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item', 'data', 'total'],
        data(){
            return{

            }
        },
        mounted() {
            //console.log('Component mounted.')
        },
        methods:{
            totalSum: function () {
                var self = this
                var total = 0
                Object.keys(self.total).forEach(function (key) {
                    if (key == "material") {
                        total += parseFloat(self.total[key].price)
                    } else {
                        total += parseFloat(self.total[key])
                    }
                })
                return total
            },
            addTerminaciones: function () {
                this.terminaciones.push({
                    terminacion:'',
                    largo:'',
                    preciomaterial:'',
                    monto:''
                });
            },
            deleteTerminaciones: function (index) {
                this.terminaciones.splice(index, 1);
                if (this.terminaciones.length === 0)
                    this.addTerminaciones()
            }
        },
    }
</script>

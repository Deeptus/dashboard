<template>
    <div class=" ">
        <!--------ITEM----------->
        <div class="card mt-5" >
            <div class="" v-for="(data,index) in items">
                <div class="card-header form-inline text-white" style="background-color: #8592A6;">
                    <div class="form-group">
                        <label>Item </label>
                        <input type="text" v-model="data.item"  class="form-control mx-3">
                    </div>
                </div>
                <!-------MATERIAL-------------->
                <material
                    :cliente="cliente"
                    :material="data.material"
                    :item="data.item"
                    :total="data.totales"
                    :superficies="superficies"
                    :materiales="materiales"
                    :adicionales="adicionales"
                ></material>

                <!-------TERMINACIONES DE BORDE-------------->
                <terminaciones
                    :item="data.item"
                    :total="data.totales"
                    :itemterminaciones="data.terminaciones"
                    :dataterminaciones="terminaciones"
                ></terminaciones>

                <!-------TRABAJOS APLICADOS-------------->
                <trabajos-aplicados
                    :itemtrabajosaplicados="data.trabajosaplicados"
                    :total="data.totales"
                    :datatrabajosaplicados="aplicados"
                    :item="data.item"
                ></trabajos-aplicados>

                <!-------TRABAJOS ESPECIALES-------------->
                <trabajos-especiales
                    :trabajosespeciales="data.trabajosespeciales"
                    :total="data.totales"
                    :item="data.item"
                ></trabajos-especiales>

                <!--------PRESUPUESTO DE ITEM----------->
                <PresupuestoItem
                    :item="data.item"
                    :total="data.totales"
                    :data="data"
                    v-if="displayPrice()"
                ></PresupuestoItem>

                <div class="text-right p-4">
                    <button @click.prevent="deleteItem(index)" class="btn btn-danger">Quitar Item</button>
                    <button @click="addItem" class="btn btn-success">Agregar Item</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Material from './MaterialComponent.vue'
    import Terminaciones from './TerminacionesComponent.vue'
    import TrabajosAplicados from './TrabajosAplicadosComponent.vue'
    import TrabajosEspeciales from './TrabajosEspecialesComponent.vue'
    import PresupuestoItem from './PresupuestoItemComponent.vue'

    export default {
        props: ['iva', 'markup', 'cliente', 'items', 'superficies', 'materiales', 'adicionales', 'terminaciones', 'aplicados'],
        components: {
            Material,
            Terminaciones,
            TrabajosAplicados,
            TrabajosEspeciales,
            PresupuestoItem,
        },
        data(){
            return{}
        },
        mounted() {
        },
        methods:{
            addItem: function () {
                this.items.push( {
                    item: '',
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
                });
            },
            deleteItem: function (index) {
                this.items.splice(index, 1);
                if (this.items.length === 0)
                    this.addItem()
            }
        },
    }
</script>

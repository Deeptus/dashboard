<template>
    <div class=" ">
        <div class="card mt-5">
            <div class="card-header">Clientes</div>
            <form class="card-body row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Apellido <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.apellido" class="form-control col-md-9" placeholder="Apellido del cliente">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Nombre <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.nombre" class="form-control col-md-9" placeholder="Nombre del cliente">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Dirección <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.direccion" class="form-control col-md-9" placeholder="Dirección de la obra">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Localidad <span class="text-danger">*</span></label>
                        <select v-model="cliente.localidad_id" @change="changeLocalidad()" class="form-control col-md-9">
                            <option value="0">
                                SELECCIONE
                            </option>
                            <option
                            v-for="(localidad, index) in localidades"
                            :value="localidad.id"
                            >
                                {{ localidad.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Teléfono 1 <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.telefono_1" class="form-control col-md-9" placeholder="Teléfono del cliente 1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Teléfono 2 <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.telefono_2" class="form-control col-md-9" placeholder="Teléfono del cliente 2">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Encargado <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.encargado" class="form-control col-md-9" placeholder="Nombre y Apellido del encargado de la obra">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" v-model="cliente.encargado_telefono" class="form-control col-md-9" placeholder="Teléfono del encargado de la obra">
                    </div>
                </div>

                <!-- Horarios de Entrega -->
                <div class="col-md-6">
                    <p class="mb-0">Horarios De Entrega <span class="text-danger">*</span></p>
                    <small>Completar los campos que correspondan (Se indican rangos horarios estimados de arribo a obra)</small>
                    <div class="row  p-4">
                        <div class="custom-control custom-radio col-md-4" v-for="hora in horasEntrega">
                            <input type="radio" :value="hora.label" v-model="cliente.horasentrega" class="custom-control-input" :id="'hora-'+hora.key">
                            <label class="custom-control-label" :for="'hora-'+hora.key">{{ hora.label }}</label>
                        </div>
                    </div>
                </div>

                <!-- Horas de Entrega -->
                <div class="col-md-6">
                    <p class="mb-0">Dias De Entrega <span class="text-danger">*</span></p>
                    <small>Completar los campos que correspondan</small>
                    <div class="row p-4">
                        <div class="custom-control custom-checkbox col-md-3" v-for="dia in diasEntrega">
                            <input type="checkbox" v-model="cliente.diasentrega" :value="dia.key" class="custom-control-input" :id="'day-'+dia.key">
                            <label class="custom-control-label" :for="'day-'+dia.key">{{ dia.label }}</label>
                        </div>
                    </div>
                </div>

                <!-- Restricciones para el ingreso a obra -->
                <div class="col-md-12 px-4">
                    <p class="mb-0">Restricciones para el ingreso a obra:</p>
                    <small>Completar los campos que correspondan</small>
                    <div class="row">
                        <div class="custom-control col-md-6 mt-3">
                            <label>
                                Certificado de cobertura ART
                            </label>
                            <select class="form-control" @change="changeR7()" v-model="cliente.restricciones['restriction-7']">
                                <option value="0">No se requiere</option>
                                <option value="1">Si se requiere</option>
                            </select>
                        </div>
                        <div class="custom-control col-md-6 mt-3">
                            <label>
                                Clausula de no repetición
                            </label>
                            <textarea class="form-control" v-model="cliente.restricciones['restriction-8']" :disabled="restriction7!=1" placeholder="Especificar" rows="1"></textarea>
                        </div>
                        <div class="custom-control col-md-6 mt-3" v-for="restriccion in restricciones">
                            <label :for="restriccion.name">
                                {{ restriccion.label }}
                            </label>
                            <textarea :id="restriccion.name" class="form-control" v-model="cliente.restricciones[restriccion.name]" placeholder="Especificar" rows="1"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cliente', 'localidades'],
        data(){
            return{
                restricciones: [
                    {
                        name: 'restriction-1',
                        label: 'Horarios en los que no se permiten ruidos en obra'
                    },
                    {
                        name: 'restriction-2',
                        label: 'Horarios en los que no se permite el uso del ascensor para carga'
                    },
                    {
                        name: 'restriction-3',
                        label: 'Restricción de ingreso de vehículos para días de lluvia'
                    },
                    {
                        name: 'restriction-4',
                        label: 'Restricción de altura o peso para ingreso de vehículos'
                    },
                    {
                        name: 'restriction-5',
                        label: 'Otros Seguros o documentación'
                    },
                    {
                        name: 'restriction-6',
                        label: 'Otras restricciones'
                    },
                ],
                diasEntrega: [
                    {
                        key: 8,
                        label: 'Indistinto'
                    },
                    /*{
                        key: 1,
                        label: 'Domingo'
                    },*/
                    {
                        key: 2,
                        label: 'Lunes'
                    },
                    {
                        key: 3,
                        label: 'Martes'
                    },
                    {
                        key: 4,
                        label: 'Miercoles'
                    },
                    {
                        key: 5,
                        label: 'Jueves'
                    },
                    {
                        key: 6,
                        label: 'Viernes'
                    },
                    /*{
                        key: 7,
                        label: 'Sabado'
                    }*/
                ],
                horasEntrega: [
                    {
                        key: 1,
                        label: '8 a 17 hs'
                    },
                    {
                        key: 2,
                        label: '8 a 12 hs'
                    },
                    {
                        key: 3,
                        label: '13 a 17 hs'
                    }
                ],
                restriction7: 0,
            }
        },
        created() {
            if (!this.cliente.restricciones['restriction-7']) {
                this.cliente.restricciones['restriction-7'] = 0
            }
            this.restriction7 = this.cliente.restricciones['restriction-7']
        },
        mounted() {
            console.log(parseInt(this.cliente.restricciones['restriction-7']))
        },
        methods: {
            changeR7() {
                this.restriction7 = parseInt(this.cliente.restricciones['restriction-7'])
                // if (this.restriction7 == 0) {
                //     this.cliente.restricciones['restriction-8'] = ''
                // }
                return true
            }
        }
    }
</script>

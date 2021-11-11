<template>
    <div class="position-relative">
        <div class="awesome-modal__fixed-btns">
            <button type="button" class="btn btn-danger" @click="componentCallback.reject('Cerrada')"><i class="fas fa-times"></i></button>
        </div>
        <div class="awesome-modal__header mt-3">
            <span>Propiedades del archivo</span>
        </div>
        <div class="awesome-modal__body py-2">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">En construcción</h1>
                </div>
            </div>
        </div>
        <div class="awesome-modal__footer text-center">
            <button type="button" class="btn btn-primary" @click="save()"><i class="fas fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-danger" @click="componentCallback.reject('Cerrada')"><i class="fas fa-times"></i> Cerrar</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        componentCallback: {},
        file: {}
    },
    data() {
        return {
            fecha: '',
            observacion: ''
        }
    },
    created() {
        // console.log(this.componentCallback)
    },
    methods: {
        validate() {
            if (! /\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/.test(this.fecha)) {
                return false
            }
            return true
        },
        save() {
            return this.componentCallback.reject('Cerrada');
            if( ! this.validate() ) {
                aa().open({style: 'error', title: 'Debe ingresar una fecha valida', sleep: 1000})
                return true
            }
            aa().open({style: 'loading'})
            var formData = new FormData()

            formData.append('fecha', this.fecha)
            formData.append('observacion', this.observacion)
            axios.post(this.endpoint, formData).then((response) => {
                aa().open({style: 'success', title: 'Se añadio una cita', sleep: 1000 })
                this.componentCallback.resolve(response.data)
            }).catch((error) => {
                
            })
        }
    }
}
</script>

<style>

</style>
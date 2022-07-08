<template>
    <div>
        <div class="awesome-modal__header py-3">
            <span>Información del Archivo:</span>
        </div>
        <div class="awesome-modal__body py-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-floating mb-2" v-if="enableEdit.original_name == true">
                        <input type="text" class="form-control" v-model="original_name">
                        <label for="floatingInput">Nombre del Archivo</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating" v-if="enableEdit.caption == true">
                        <textarea class="form-control" style="height: 100px" v-model="caption"></textarea>
                        <label for="floatingTextarea2">Observación</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="awesome-modal__footer text-center pb-3">
            <button type="button" class="btn btn-primary" @click="save()"><i class="fas fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-danger" @click="componentCallback.reject('Cerrada')"><i class="fas fa-times"></i> Cerrar</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        componentCallback: {},
        item: {},
        enableEdit: {}
    },
    data() {
        return {
            alt: '',
            caption: '',
            original_name: null
        }
    },
    created() {
        if (this.item.info) {
            this.alt           = this.item.info.alt
            this.caption       = this.item.info.caption
            this.original_name = this.item.info.original_name
        } else {
            this.alt           = this.item.alt
            this.caption       = this.item.caption
            this.original_name = this.item.original_name
        }
    },
    methods: {
        save() {
        if (this.item.info) {
            this.item.info.alt           = this.alt
            this.item.info.caption       = this.caption
            this.item.info.original_name = this.original_name
        } else {
            this.item.alt           = this.alt
            this.item.caption       = this.caption
            this.item.original_name = this.original_name
        }

            this.componentCallback.resolve(this.item)
        }
    }
}
</script>

<style>

</style>
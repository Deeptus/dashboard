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
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="filename"
                                    placeholder="Nombre del Archivo"
                                    v-model="file.filename"
                                >
                                <label for="filename">Nombre del Archivo</label>
                            </div>
                        </div>
                    </div>
                    <pre>{{ file }}</pre>
                </div>
                <div class="col-md-3">
                    <img :src="file.url" class="img-fluid" alt="">
                    <table class="table table-sm mt-3">
                        <tbody>
                            <tr>
                                <th>Tipo</th>
                                <td>{{ file.type }}</td>
                            </tr>
                            <tr>
                                <th>Tamaño</th>
                                <td>{{ sizeHumanReadable(file.size) }}</td>
                            </tr>
                            <tr>
                                <th>Ancho</th>
                                <td>{{ file.width }}px</td>
                            </tr>
                            <tr>
                                <th>Altura</th>
                                <td>{{ file.height }}px</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-block" @click="optimizeFile()" v-if="file.type != 'image/svg+xml' && file.type != 'image/svg' && file.type != 'image/webp'">
                        <i class="fas fa-sync-alt"></i>
                        Optimizar
                    </button>
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
        endpoint: {
            type: String,
            required: true
        },
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
        },
        sizeHumanReadable(size) {
            let units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            let i = 0
            while (size >= 1024) {
                size /= 1024
                ++i
            }
            // console.log(size)
            return size.toFixed(1) + ' ' + units[i]
        },
        optimizeFile() {
            aa().open({style: 'loading'})
            axios.post(this.endpoint + '/optimize/' + this.file.id).then((response) => {
                Object.assign(this.file, response.data)
                this.$forceUpdate()
                aa().open({style: 'success', title: 'Se optimizo el archivo', sleep: 1000 })
            }).catch((error) => {
                
            })
        }
    }
}
</script>

<style>

</style>
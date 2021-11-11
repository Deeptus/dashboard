<template>
    <div class="card">
        <div class="card-header">
            Añadir Tarea
            <div class="card-header-btns">
                <button type="button" class="btn btn-warning" @click="state.display = 'list'"><i class="fas fa-arrow-left"></i> Volver</button>
                <button type="button" class="btn btn-primary" @click="save"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" v-model="title" placeholder="Titulo">
                        <label>Titulo</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select2 :multiple="true" v-model="users">
                            <option :value="user.id" v-for="(user, key) in state.users" :key="key">{{ user.username }}</option>
                        </select2>
                        <label>Usuarios</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" v-model="individual">
                            <option :value="1">Si</option>
                            <option :value="0">No</option>
                        </select>
                        <label>La terea se realiza en conjunto</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="datetime-local" class="form-control" v-model="start_at" placeholder="Titulo">
                        <label>Realizarla</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="datetime-local" class="form-control" v-model="finish_at" placeholder="Titulo">
                        <label>Finalizarla</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label>Detalles</label>
                        <jodit-vue
                            v-model="details"
                            :value="details"
                        ></jodit-vue>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="card-header-btns">
                <button type="button" class="btn btn-warning" @click="state.display = 'list'"><i class="fas fa-arrow-left"></i> Volver</button>
                <button type="button" class="btn btn-primary" @click="save"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</template>

<script>
import 'jodit/build/jodit.min.css'
import { JoditEditor } from 'jodit-vue'
import select2 from '../Select2FloatingComponent.vue'
export default {
    props: {
        endpoint: {
            type: String,
            default: ''
        },
        state: {
            type: Object,
            default: {}
        }
    },
    components: {
        'jodit-vue': JoditEditor,
        select2
    },
    data() {
        return { 
            title: '',
            start_at: '',
            finish_at: '',
            details: '',
            individual: 1,
            users: []
        }
    },
    methods: {
        save() {
            let formData = new FormData()

            formData.append('title', this.title);
            formData.append('start_at', this.start_at);
            formData.append('finish_at', this.finish_at);
            formData.append('details', this.details);
            formData.append('individual', this.individual);
            formData.append('users', JSON.stringify(this.users));

            axios.post(this.endpoint + '/save', formData).then((response) => {
                // this.loaded = 3
                setTimeout(() => {
                    // this.loaded = 1
                    // window.location.href = this.urlBack
                }, 1000);
            }).catch((error) => {
            })
        }
    }
}
</script>

<style>

</style>
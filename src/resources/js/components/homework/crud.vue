<template>
    <div>
        <div class="card" v-if="state.display == 'list'">
            <div class="card-header">
                Listado de tareas asignadas
                <div class="card-header-btns">
                    <button type="button" class="btn btn-primary" @click="add"><i class="fas fa-plus"></i> Añadir</button>
                </div>
            </div>
            <table class="table table-striped table-hover m-0 card-body">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Realizar</th>
                        <th>Asignado por</th>
                        <th>Asignado a</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, key) in state.records" :key="key">
                        <td>{{ record.title }}</td>
                        <td>{{ record.start_at }}</td>
                        <td>{{ record.user_name }}</td>
                        <td>
                            <table class="table table-bordered border-dark m-0">
                                <tr v-for="(state, skey) in record.users_state" :key="skey">
                                    <th>{{ state.name }}</th>
                                    <td>
                                        <i v-if="state.pivot.read_at" class="fas fa-eye"></i>
                                        <i v-if="state.pivot.finished_at" class="far fa-check-circle"></i>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>{{ !record.finished_at?'Pendiente':'Realizada' }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <crud-form v-if="state.display == 'add'" :endpoint="endpoint" :state="state" />
    </div>
</template>

<script>
import crudForm from './crud-form.vue'
export default {
    components: {
        'crud-form': crudForm
    },
    data() {
        return {
            endpoint: '',
            state: {
                display: 'loading'
            }
        }
    },
    created () {
        this.endpoint = window.apis.homework;
        axios.get(this.endpoint + '/data').then((response) => {
            this.state.records = response.data.records
            this.state.users   = response.data.users
            this.state.groups  = response.data.groups
            this.state.display = 'list'
        })
    },
    methods: {
        add() {
            this.state.display = 'add'
        }
    }
}
</script>

<style>

</style>
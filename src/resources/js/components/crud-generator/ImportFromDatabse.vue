<template>
    <div class="position-relative">
        <div class="awesome-modal__fixed-btns">
            <button type="button" class="btn btn-danger" @click="componentCallback.reject('Cerrada')"><i class="fas fa-times"></i></button>
        </div>
        <div class="awesome-modal__header">
            <span>Datos del Vehículo:</span>
        </div>
        <div class="awesome-modal__body py-4 mb-0">
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action" @click="select(table)" v-for="table in tables" :key="table">{{ table }}</button>
            </div>
        </div>
        <div class="awesome-modal__footer text-center mb-3 pt-3">
            <button type="button" class="btn btn-danger ms-3" @click="componentCallback.reject('Cerrada')"><i class="fas fa-times"></i> Cerrar</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        componentCallback: {},
        endpoint: {},
    },
    data() {
        return {
            tables: []
        }
    },
    created() {
        this.$nextTick(() => {
            axios.get(this.endpoint + '/api/list-tables').then((response) => {
                this.tables = response.data;
            });
        });
    },
    methods: {
        select(table) {
            aa().open({style: 'loading'})

            var formData = new FormData()
            formData.append('table', table)
            axios.post(this.endpoint + '/api/table-info', formData).then((response) => {
                aa().close()
                this.componentCallback.resolve({ info: response.data.info, columns: response.data.columns })
            }).catch((error) => {

            })
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
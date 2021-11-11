<template>
    <div class="homework-modal" v-if="display">
        <div class="homework-modal__container">
            <div class="homework-modal__header">
                <span>{{ homework.title }}</span>
            </div>
            <div class="homework-modal__body">
                <table class="table table-bordered m-0">
                    <tr>
                        <th>Asignado:</th>
                        <td>{{ homework.created_at_ago }}</td>
                        <th>Por:</th>
                        <td>{{ homework.user_name }}</td>
                        <th>Realizar:</th>
                        <td>{{ homework.start_at_formated }}</td>
                    </tr>
                </table>
                <strong>Detalle:</strong>
                <div v-html="homework.details"></div>
            </div>
            <div class="homework-modal__footer text-center">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="button" class="btn btn-warning" @click="completed"><i class="fas fa-check"></i> Marcar como completada</button>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-danger" @click="display = false"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Swal from 'sweetalert2'
    export default {
        name: 'HomeworkShow',
        components: {},
        data(){
            return{
                uuid: '',
                endpoint: '',
                homework: {},
                display: false
            }
        },
        created() {
        },
        mounted: function () {},
        methods:{
            open(uuid) {
                this.endpoint = window.apis.homework;
                this.uuid = uuid
                
                let formData = new FormData()

                formData.append('uuid', this.uuid);

                axios.post(this.endpoint + '/find', formData).then((response) => {
                    // this.loaded = 3
                    Object.assign(this.homework, response.data)
                    this.display = true
                }).catch((error) => {
                })
                // document.body.style.overflow = "hidden"
            },
            completed() {
                Swal.fire(
                    'Good job!',
                    '',
                    'success'
                )
            }
        },
        watch: {},
        destroyed: function () {}
    }
</script>
<style lang="scss" scoped>
    .homework-modal {
        background-color: rgba($color: #000000, $alpha: .4);
        position: fixed;
        top: 0;
        width: 100%;
        height: 100vh;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: flex;
        &__container {
            position: sticky;
            background-color: #ffffff;
            overflow: hidden;
            width: 100%;
            max-width: 800px;
        }
        &__body {
            border-bottom: 1px solid #cbc8d0;
            border-top: 1px solid #cbc8d0;
            padding: 10px 16px;
            max-height: calc(100vh - 215px);
            overflow-y: auto;
        }
        &__footer {
        }
        &__header {
            margin: 0;
            padding: 10px 16px;
            font-size: 20px;
            font-weight: 600;
        }
    }
</style>
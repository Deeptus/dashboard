<template>
    <div class="notification-modal" v-if="display">
        <div class="notification-modal__container">
            <div class="notification-modal__header">
                <span>{{ notification.title }}</span>
            </div>
            <div class="notification-modal__body">
                <table class="table table-bordered m-0">
                    <tr>
                        <td>{{ notification.created_at_ago }}</td>
                    </tr>
                </table>
                <strong>{{ notification.data.title }}</strong>
                <div v-html="'<div>'+notification.data.message+'</div>'"></div>
            </div>
            <div class="notification-modal__footer text-center">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <a v-for="(action, key) in notification.data.action" :key="key" :href="action.action" class="btn btn-primary">{{ action.text }}</a>
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
        name: 'NotificationShow',
        components: {},
        data(){
            return{
                id: '',
                endpoint: '',
                notification: {},
                display: false
            }
        },
        created() {
        },
        mounted: function () {},
        methods:{
            open(id) {
                this.endpoint = window.apis.notification;
                this.id = id
                
                let formData = new FormData()

                formData.append('id', this.id);

                axios.post(this.endpoint + '/find', formData).then((response) => {
                    // this.loaded = 3
                    Object.assign(this.notification, response.data)
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
    .notification-modal {
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
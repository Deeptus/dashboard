<template>
    <div class="login-form-modal" v-if="display">
        <div class="login-form-modal__container container mt-5">
            <div class="login-form-modal__header">
                <span>Iniciar sesión:</span>
            </div>
            <div class="login-form-modal__body">
                <div class="alert alert-danger mb-0 mt-2" role="alert" v-if="invalidCredentials">
                    Estas credenciales no coinciden con nuestros registros.
                </div>
                <div class="form-group">
                    <label for="username" class="col-form-label">Usuario:</label>
                    <input type="text" class="form-control" id="username" v-model="username">
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" v-model="password">
                </div>
            </div>
            <div class="login-form-modal__footer text-center">
                <button type="button" class="btn btn-primary" @click="login()">Ingresar</button>
            </div>
        </div>
    </div>
</template>
<script>
    Vue.mixin({
        methods: {
            openLoginFormModal() {
                this.$root.$refs.loginformmodal.openModal()
            }
        }
    })

    export default {
        props: ['action'],
        components: {},
        data(){
            return{
                username: '',
                password: '',
                display: false,
                invalidCredentials: false 
            }
        },
        created() {
        },
        mounted: function () {},
        methods:{
            openModal() {
                this.display = true
                // document.body.style.overflow = "hidden"
            },
            login() {
                var form = new FormData()

                form.append('username', this.username)
                form.append('password', this.password)

                axios.post(this.action, form).then((response) => {
                    if (response.data.status == 'error') {
                        this.backendErrors = response.data.errors
                        this.loaded = 1
                    }
                    if (response.data.status == 'success') {
                        window.csrfUpdateCounter = 0
                        this.display = false
                    }
                })
                .catch((error) => {
                    // handle error
                    if (error.response.data.message == 'The given data was invalid.') {
                        this.invalidCredentials = true
                        setTimeout(() => {
                            this.invalidCredentials = false
                        }, 10000)
                        return true
                    }
                    if (error.response.data.message == 'CSRF token mismatch.') {
                        csrf.refresh()
                        .then(() => {
                            this.login()
                        })
                        .catch((err) => {
                            console.log('No se que hacer')
                        });
                        return true
                    }
                    // console.log(error)
                })
                .then(() => {
                    // console.log('siempre')
                    // always executed
                })
            }
        },
        watch: {},
        destroyed: function () {}
    }
</script>
<style lang="scss" scoped>
    .login-form-modal {
        background-color: rgba($color: #000000, $alpha: .4);
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        &__container {
            position: sticky;
            top: 50px;
            background-color: #ffffff;
            overflow: hidden;
        }
        &__body {
            border-bottom: 1px solid #cbc8d0;
            border-top: 1px solid #cbc8d0;
            margin-top: 9px;
            margin-bottom: 16px;
        }
        &__footer {
            margin-bottom: 1.5rem;
        }
        &__header {
            margin-top: 1rem;
            font-size: 20px;
            font-weight: 600;
        }
    }
</style>
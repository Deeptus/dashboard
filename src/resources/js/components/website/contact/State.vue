<template>
    <div class="row">
        <div class="col s12">
            <div class="row" v-if="componentState == 0">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Cargando
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 'saving'">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Enviando, por favor espere
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 'message-sent'">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-paper-plane"></i>
                        <div class="message-text">
                            Su mensaje se ha enviado con éxito
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 4">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="message-text">
                            No ha seleccionado ningun producto
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 5">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Procesando el pedido
                        </div>
                        <div class="message-text opacity-animation" style="font-size: 1.5em;color: rgba(19, 70, 102, 0.5);" v-if="this.errorBuyCounter > 1">
                            intento numero: <strong>{{ this.errorBuyCounter }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 6">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Guardando el pedido
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 7">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Conectando a Mercado Pago
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="componentState == 8">
                <div class="col-md-12">
                    <div class="message-container">
                        <i class="fas fa-sync fa-spin"></i>
                        <div class="message-text opacity-animation">
                            Ocurrio un error Reconectando
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            componentState: {
                default: ''
            }
        },
        components: {
        },
        data(){
            return{}
        },
        created() {
            this.$nextTick(() => {
            });
        },
        updated: function () {
            this.$nextTick(function () {
            })
        },
        methods: {
        }
    }
</script>
<style lang="scss" scoped>
@keyframes opacity-change {
    0% { opacity: .8; color: #00577A; }
    50% { color: .2; color: #b5b5b5; }
    100% { color: .8; color: #00577A; }
}
.message-container {
    text-align: center;
    padding: 73px 0 73px 0;
    i {
        font-size: 11em;
        color: #b5b5b5;
        margin-bottom: 30px;
        opacity: .7;
    }
    .message-text {
        text-align: center;
        font-size: 3em;
        font-weight: 500;
        color: #b5b5b5;
        letter-spacing: 2px;
        font-weight: bold;
        .opacity-animation {
            animation: opacity-change 2s infinite;
        }
    }
}
</style>

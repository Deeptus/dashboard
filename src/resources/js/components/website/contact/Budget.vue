<template>
<div>
    <div class="row">
        <div class="col-md-2">
            <div class="presupuesto-title">
                <div :class="'presupuesto-title__image color--'+step1">
                    <i class="fas fa-clipboard"></i>
                </div>
                <hr :class="'color--'+step1">
            </div>
        </div>
        <div :class="'col-md-10 presupuesto-title__text color--'+step1">DATOS</div>
    </div>
    <div class="row">
        <div :class="'offset-md-2 col-md-10'">
            <div class="row">
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.name"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.company"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.phone"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.email"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-12 mb-3" :input="form.inputs.address"></form-contact-request-input-text>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-6 d-flex align-items-end justify-content-end mb-3" v-if="step == 1" @click="goStep2()">
                    <button class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="step == 2">
        <div class="col-md-2">
            <div class="presupuesto-title">
                <div :class="'presupuesto-title__image color--'+step2">
                    <i class="fas fa-comments"></i>
                </div>
                <hr :class="'color--'+step2">
            </div>
        </div>
        <div :class="'col-md-10 presupuesto-title__text color--'+step2">CONSULTA</div>
    </div>
    <div class="row mb-5" v-if="step == 2">
        <div :class="'offset-md-2 col-md-10'">
            <div class="row">
                <form-contact-request-input-text class="col-md-12 mb-3" type="textarea" :input="form.inputs.message"></form-contact-request-input-text>
                <div class="col-md-12 mb-3">
                    <label for="formFile" class="form-label m-0">Examinar Archivo </label>
                    <input class="form-control" type="file" id="formFile" @change="selectFile($event)">
                </div>
            </div>
            <div class="row" v-if="form.cart.length">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, key) in form.cart" :key="key">
                                <td><div class="cart__item-image" :style="'background-image: url(' + item.image_url + ')'"></div></td>
                                <td>{{ item.code }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            v-bind:true-value="1"
                            v-bind:false-value="0"
                            v-model.number="form.inputs.accept_conditions.value"
                            class="form-check-input"
                            id="accept_conditions"
                            :disabled="form.inputs.accept_conditions.disabled"
                            >
                        <label class="custom-control-label" for="accept_conditions">Acepto los términos y condiciones de privacidad</label>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end justify-content-end">
                    <button class="btn btn-primary" :class="{ 'disabled': form.inputs.accept_conditions.value != 1 || form.state == 'saving' }" @click="form.submit()">Enviar consulta</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        props: {
            form: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        },
        components: {
            },
        data(){
            return {
                step: 1,
                step1: 'orange',
                step2: 'orange'
            }
        },
        created() {
            this.$nextTick(() => {});
        },
        methods: {
            selectFile(event) {
                const file = event.target.files[0]
                if ( !this.form.validateFile(file) ) {
                    event.target.value = ""
                    this.form.inputs.files.value = []
                    return false
                }
                this.form.inputs.files.value = [ file ]
            },
            goStep2() {
                this.step1 = 'gray'
                this.step = 2
            }
        }
    }
</script>
<style lang="scss" scoped>
.presupuesto-title {
    display: flex;
    justify-content: center;
    align-items: center;
    .presupuesto-title__image {
        border-radius: 100%;
        border: 4px solid var(--gray);
        color: var(--gray);
        font-size: 25px;
        width: 100px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        &.color--orange {
            border: 4px solid var(--primary);
            color: var(--primary);
        }
        img {
            max-width: 55px;
            max-height: 55px;
        }
    }
    hr {
        border-bottom: 4px solid var(--gray);
        &.color--orange {
            border-bottom: 4px solid var(--primary);
        }
        flex: 1;
    }
}
.presupuesto-title__text {
    display: flex;
    align-items: center;
    font-weight: 700;
    font-size: 25px;
    color: var(--gray);
    &.color--orange {
        color: var(--primary);
    }
}
.cart__item-image {
    width: 50px;
    height: 50px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}
</style>
<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.name"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" type="email" :input="form.inputs.email"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.phone"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-6 mb-3" :input="form.inputs.company"></form-contact-request-input-text>
                <form-contact-request-input-text class="col-md-12 mb-3" type="textarea" :input="form.inputs.message"></form-contact-request-input-text>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            v-bind:true-value="1"
                            v-bind:false-value="0"
                            v-model.number="form.inputs.accept_conditions.value"
                            class="form-check-input"
                            id="accept_conditions"
                            :disabled="form.inputs.accept_conditions.disabled"
                            >
                        <label class="form-check-label" for="accept_conditions">Acepto los términos y condiciones de privacidad</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-end justify-content-end">
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
        components: {},
        data(){
            return {}
        },
        created() {
            this.$nextTick(() => {});
        },
    }
</script>
<style lang="scss" scoped></style>
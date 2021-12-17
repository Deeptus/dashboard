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
                        <button class="btn btn-primary" :class="{ 'disabled': form.inputs.accept_conditions.value != 1 || form.state == 'saving' }" @click="submit()">Enviar consulta</button>
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
            this.form.addInput({
                key: 'accept_conditions',
                value: 0,
                label: 'Acepto los términos y condiciones de privacidad'
            })
            this.form.addInput({
                key: 'name',
                value: '',
                label: 'Nombre (*)',
                rules: {
                    required: true,
                }
            })
            this.form.addInput({
                key: 'company',
                value: '',
                label: 'Empresa',
                rules: {
                    required: false,
                }
            })
            this.form.addInput({
                key: 'phone',
                value: '',
                label: 'Teléfono (*)',
                rules: {
                    required: true
                }
            })
            this.form.addInput({
                key: 'email',
                value: '',
                label: 'Email (*)',
                rules: {
                    required: true,
                    email: true
                }
            })
            this.form.addInput({
                key: 'message',
                value: '',
                label: 'Escriba acá su mensaje',
                rules: {
                    required: true
                }
            })
            this.form.addInput({
                key: 'address',
                value: '',
                label: 'Dirección'
            })
            this.form.addInput({
                key: 'files',
                value: [],
                label: 'Archivos adjuntos',
                rules: {
                    required: false
                }
            })
            this.$nextTick(() => {
                if (typeof window.getSpsi === "function" && window.getSpsi()) {
                    this.form.inputs.name.value     = window.getSpsi().fullname
                    this.form.inputs.company.value  = window.getSpsi().business_name
                    this.form.inputs.phone.value    = window.getSpsi().phone
                    this.form.inputs.email.value    = window.getSpsi().email
                }
            });
        },
        methods: {
            submit() {
                this.form.formData.append('name',            this.form.inputs.name.value);
                this.form.formData.append('email',           this.form.inputs.email.value);
                this.form.formData.append('phone',           this.form.inputs.phone.value);
                this.form.formData.append('address',         this.form.inputs.address.value);
                this.form.formData.append('company',         this.form.inputs.company.value);
                this.form.formData.append('message',         this.form.inputs.message.value);
                this.form.formData.append('type',            'contact-message');
                this.form.formData.append('cart',            JSON.stringify(this.form.cart));
                if (this.form.inputs.files.value.length) {
                    this.form.inputs.files.value.forEach((file, key) => {
                        if (file && file instanceof File) {
                            this.form.formData.append('files['+key+']', file);
                        }
                    })
                }
                this.form.submit()
            }
        }
    }
</script>
<style lang="scss" scoped></style>
<template>
    <div class="row">
        <contact-message :form="form" v-if="type == 'contact-message'"></contact-message>
        <budget :form="form" v-if="type == 'budget'"></budget>
    </div>
</template>

<script>
    import InputText from './inputs/text.vue'
    import ContactMessage from './ContactMessage.vue'
    import Budget from './Budget.vue'
    export default {
        props: {
            endpoint: {},
            type: {
                default: 'contact-message'
            },
        },
        components: {
            'input-text': InputText,
            'contact-message': ContactMessage,
            'budget': Budget
        },
        data(){
            return {
                form: {
                    recaptcha_token: '',
                    state: null,
                    errors: {
                        hasErrors: false,
                        messages: {}
                    },
                    inputs: {
                        name: {
                            value: '',
                            label: 'Nombre (*)',
                            errors: [],
                            disabled: false
                        },
                        company: {
                            value: '',
                            label: 'Empresa',
                            errors: [],
                            disabled: false
                        },
                        phone: {
                            value: '',
                            label: 'Teléfono (*)',
                            errors: [],
                            disabled: false
                        },
                        email: {
                            value: '',
                            label: 'Email (*)',
                            errors: [],
                            disabled: false
                        },
                        message: {
                            value: '',
                            label: 'Escriba acá su mensaje',
                            errors: [],
                            disabled: false
                        },
                        address: {
                            value: '',
                            label: 'Dirección',
                            errors: [],
                            disabled: false
                        },
                        accept_conditions: {
                            value: '',
                            disabled: false
                        },
                    },
                    cart: [],
                    submit: () => {
                        this.recaptcha()
                    }
                }
            }
        },
        created() {
            this.$nextTick(() => {
                let cart = localStorage.getItem('budget')
                if (cart) {
                    this.form.cart = Object.values(JSON.parse(cart))
                }

                if (window.getSpsi()) {
                    this.form.inputs.name.value     = window.getSpsi().fullname
                    this.form.inputs.company.value  = window.getSpsi().business_name
                    this.form.inputs.phone.value    = window.getSpsi().phone
                    this.form.inputs.email.value    = window.getSpsi().email
                }
            });
        },
        updated() {
            this.$nextTick(() => {})
        },
        methods: {
            validate() {
                this.form.errors.hasErrors = false
                const data = {
                    name: this.form.inputs.name.value,
                    company: this.form.inputs.company.value,
                    phone: this.form.inputs.phone.value,
                    email: this.form.inputs.email.value,
                    message: this.form.inputs.message.value
                };
                const rules = [
                    {
                        key: 'email',
                        name: 'Correo Electrónico',
                        rules: {
                            required: true,
                            email: true
                        }
                    },
                    {
                        key: 'name',
                        name: 'Nombre',
                        rules: {
                            required: true
                        }
                    },
                    {
                        key: 'phone',
                        name: 'Teléfono',
                        rules: {
                            required: true
                        }
                    },
                    {
                        key: 'message',
                        name: 'Consulta',
                        rules: {
                            required: true
                        }
                    }
                ]
                rules.forEach(rule => {
                    this.$set(this.form.errors.messages, rule.key, [])
                    this.$set(this.form.inputs[rule.key], 'errors', [])
                    if (rule.rules.required == true) {
                        if (!data[rule.key] && !data[rule.key].length > 0) {
                            this.form.errors.messages[rule.key].push('El campo <strong>' + rule.name + '</strong> no puede estar vacío')
                            this.form.inputs[rule.key].errors.push('El campo <strong>' + rule.name + '</strong> no puede estar vacío')
                            this.form.errors.hasErrors = true
                        }
                    }
                    if (data[rule.key] && rule.rules.email == true) {
                        if (!/\S+@\S+\.\S+/.test(data[rule.key])) {
                            this.form.errors.messages[rule.key].push('El campo <strong>' + rule.name + '</strong> debe tener un formato de email valido')
                            this.form.errors.hasErrors = true
                        }
                    }
                })
            },
            async recaptcha() {
                this.validate()
                if (this.form.errors.hasErrors) {
                    return false
                }
                this.form.state = 'saving'
                // this.disabledForm = true
                try {
                    // (optional) Wait until recaptcha has been loaded.
                    await this.$recaptchaLoaded()

                    // Execute reCAPTCHA with action "login".
                    const token = await this.$recaptcha('login')
                    this.form.recaptcha_token = token
                } catch(e) {
                    this.form.state = null
                }
                this.postForm()
            },
            postForm() {
                var formData = new FormData();
                formData.append('name',            this.form.inputs.name.value);
                formData.append('email',           this.form.inputs.email.value);
                formData.append('phone',           this.form.inputs.phone.value);
                formData.append('address',         this.form.inputs.address.value);
                formData.append('company',         this.form.inputs.company.value);
                formData.append('message',         this.form.inputs.message.value);
                formData.append('type',            this.type);
                formData.append('recaptcha_token', this.form.recaptcha_token);
                formData.append('cart',            JSON.stringify(this.form.cart));

                axios.post(this.endpoint + '/contact/submit', formData).then((response) => {
                    this.form.state = null
                    setTimeout(function(){
                       // window.location.href = this.urlBack
                    }.bind(this), 1000)
                })
                .catch((error) => {
                    this.form.state = null
                    console.log('dio error')
                    setTimeout( () => {
                        if (error.response.data.errors) {
                            Object.assign(this.form.errors,  error.response.data.errors)
                        }
                        if (error.response.data.message) {
                            let message = ''
                            switch (error.response.data.message) {
                                case 'The given data was invalid.':
                                    message = 'Los datos proporcionados no son válidos.'
                                    break;
                            
                                default:
                                    message = error.response.data.message
                                    break;
                            }
                            this.$set(this.form.errors.messages, 'server_callback', [])
                            this.form.errors.messages.server_callback.push(message)
                        }
                    }, 1000 );
                    // console.log(['error', error.response.data]);
                })

            },
        }
  }
</script>
<style lang="scss" scoped>

</style>
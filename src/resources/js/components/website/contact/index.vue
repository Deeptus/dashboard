<template>
    <div class="row">
        <template v-if="form.state == null">
            <contact-message :form="form" v-if="type == 'contact-message'"></contact-message>
            <budget :form="form" v-if="type == 'budget'"></budget>
            <shopping-cart :form="form" v-if="type == 'shopping-cart'"></shopping-cart>
            <component :is="component" :form="form" v-if="type == 'custom-component'"></component>
            <div class="col-md-12 text-end" v-if="app_debug">
                <button type="button" class="badge bg-secondary" @click="faker()"><i class="fas fa-random"></i></button>
            </div>
        </template>
        <div class="col-md-12" v-else>
            <state :componentState="form.state"></state>
        </div>
    </div>
</template>

<script>
    import InputText from './inputs/text.vue'
    import ContactMessage from './ContactMessage.vue'
    import Budget from './Budget.vue'
    import ShoppingCart from './ShoppingCart.vue'
    import State from './State.vue'
    import faker from 'faker'
    import Swal from 'sweetalert2'

    export default {
        props: {
            endpoint: {},
            type: {
                default: 'contact-message'
            },
            component: {
                default: null
            }
        },
        components: {
            'state': State,
            'input-text': InputText,
            'contact-message': ContactMessage,
            'budget': Budget,
            'shopping-cart': ShoppingCart,
        },
        data(){
            return {
                app_debug: window.app_debug,
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
                        files: {
                            value: [],
                            disabled: false
                        },
                    },
                    rules:[
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
                    ],
                    cart: [],
                    formData: new FormData(),
                    submit: () => {
                        this.recaptcha()
                    },
                    validateFile: (file) => {
                        return this.validateFile(file)
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

                if (typeof window.getSpsi === "function" && window.getSpsi()) {
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
            validateFile(file) {
                const maxSize = 1.1 * 1024 * 1000
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'El tamaño del archivo excede el maximo permitido',
                        html: 'El archivo no puede exeder a <strong>1mb</strong>',
                    })
                    return false
                }
                const types = [
                    {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ext: 'xlsx',
                        description: 'Excel'
                    },
                    {
                        type: 'application/vnd.ms-excel',
                        ext: 'xls',
                        description: 'Excel'
                    },
                    {
                        type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ext: 'docx',
                        description: 'Word'
                    },
                    {
                        type: 'application/msword',
                        ext: 'doc',
                        description: 'Word'
                    },
                    {
                        type: 'application/pdf',
                        ext: 'pdf',
                        description: 'PDF'
                    },
                    {
                        type: 'image/png',
                        ext: 'png',
                        description: 'Imagen'
                    },
                    {
                        type: 'image/jpeg',
                        ext: 'jpeg',
                        description: 'Imagen'
                    },
                ]
                let formatValid = false
                let formatErrorMessage = []
                types.forEach(t => {
                    formatErrorMessage.push('<strong>' + t.description + '</strong>(.' + t.ext + ')')
                    if (file.type == t.type) {
                        formatValid = true
                    }
                })
                if (!formatValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'El archivo seleccionado no es de formato valido',
                        html: 'Puede subir cualquiera de los siguientes formatos: ' + formatErrorMessage.join(', '),
                    })
                    return false
                }
                return true
            },
            validate() {
                this.form.errors.hasErrors = false
                const data = {
                    name: this.form.inputs.name.value,
                    company: this.form.inputs.company.value,
                    phone: this.form.inputs.phone.value,
                    email: this.form.inputs.email.value,
                    message: this.form.inputs.message.value
                };
                this.form.rules.forEach(rule => {
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
                this.form.formData.append('name',            this.form.inputs.name.value);
                this.form.formData.append('email',           this.form.inputs.email.value);
                this.form.formData.append('phone',           this.form.inputs.phone.value);
                this.form.formData.append('address',         this.form.inputs.address.value);
                this.form.formData.append('company',         this.form.inputs.company.value);
                this.form.formData.append('message',         this.form.inputs.message.value);
                this.form.formData.append('type',            this.type);
                this.form.formData.append('recaptcha_token', this.form.recaptcha_token);
                this.form.formData.append('cart',            JSON.stringify(this.form.cart));
                if (this.form.inputs.files.value.length) {
                    this.form.inputs.files.value.forEach((file, key) => {
                        if (file && file instanceof File) {
                            this.form.formData.append('files['+key+']', file);
                        }
                    })
                }
                axios.post(this.endpoint + '/contact/submit', this.form.formData).then((response) => {
                    setTimeout(function(){
                        this.form.state = 'message-sent'
                       // window.location.href = this.urlBack
                    }.bind(this), 1000)
                })
                .catch((error) => {
                    this.form.state = null
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
                })

            },
            faker() {
                faker.locale = "es"
                window.faker = faker
                this.form.inputs.name.value    = faker.name.findName()
                this.form.inputs.company.value = faker.company.companyName()
                this.form.inputs.phone.value   = faker.phone.phoneNumber()
                this.form.inputs.email.value   = faker.internet.email()
                this.form.inputs.message.value = faker.lorem.paragraph()
                                
                return true
            }
        }
  }
</script>
<style lang="scss" scoped>
    .badge {
        border: none;
        font-size: 11px;
    }
</style>
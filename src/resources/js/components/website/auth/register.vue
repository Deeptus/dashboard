
<template>
    <div>
        <form method="POST" v-if="componentState != 'registration-completed'" v-on:submit.prevent="recaptcha" class="row form__layout">
            <div class="col-md-12" v-if="Object.values(errors).length">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Se encontraron los siguientes errores: </strong>
                    <ul class="mt-2">
                        <template v-for="(i, index) in Object.values(errors)">
                            <template v-if="Object.prototype.toString.call( i ) == '[object Array]'">
                                <li v-for="(m, mindex) in i" :key="index + '-' + mindex" v-html="m"></li>
                            </template>
                            <li v-else v-html="i" :key="index"></li>
                        </template>
                    </ul>
                </div>
            </div>
            <div class="col-md-12" v-if="this.status == 'success'">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Su registro se completo con éxito</h4>
                    <p>Ahora ya puede iniciar sesion usando su correo electronico y contraseña</p>
                </div>
            </div>
            <template v-if="this.status != 'success'">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="full_name"
                            placeholder="Persona de Contacto / Nombre y Apellido *"
                            aria-label="Persona de Contacto / Nombre y Apellido *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="full_name"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.full_name"
                            :disabled="status == 'sending'"
                        />
                        <label>Persona de Contacto / Nombre y Apellido *</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="dni"
                            placeholder="Persona de Contacto / Nombre y Apellido *"
                            aria-label="Persona de Contacto / Nombre y Apellido *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="dni"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.dni"
                            :disabled="status == 'sending'"
                        />
                        <label>DNI</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="phone"
                            placeholder="Número de teléfono *"
                            aria-label="Número de teléfono *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="phone"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.phone"
                            :disabled="status == 'sending'"
                        />
                        <label>Número de teléfono *</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="address"
                            placeholder="Dirección de Domicilio"
                            aria-label="Dirección de Domicilio"
                            aria-describedby="basic-addon1"
                            autocomplete="address"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.address"
                            :disabled="status == 'sending'"
                        />
                        <label>Dirección de Domicilio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="business_name"
                            placeholder="Razón Social / Empresa"
                            aria-label="Razón Social / Empresa"
                            aria-describedby="basic-addon1"
                            autocomplete="business_name"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.business_name"
                            :disabled="status == 'sending'"
                        />
                        <label>Razón Social / Empresa</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Tipo de Contribuyente" v-model="input.type_taxpayer_id">
                            <option :value="i.id" v-for="(i, k) in type_taxpayer" :key="k">{{ i.name }}</option>
                        </select>
                        <label>Tipo de Contribuyente</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="cuit"
                            placeholder="CUIT"
                            aria-label="CUIT"
                            aria-describedby="basic-addon1"
                            autocomplete="cuit"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.cuit"
                            :disabled="status == 'sending'"
                        />
                        <label>CUIT</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Tipo de Contribuyente" v-model="input.location_1_id">
                            <option :value="i.id" v-for="(i, k) in locations_1" :key="k">{{ i.name }}</option>
                        </select>
                        <label>Provincia</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Tipo de Contribuyente" v-model="input.location_2_id">
                            <option :value="i.id" v-for="(i, k) in filteredLocations2" :key="k">{{ i.name }}</option>
                        </select>
                        <label>Localidad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            name="zip"
                            placeholder="Código Postal *"
                            aria-label="Código Postal *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="zip"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.zip"
                            :disabled="status == 'sending'"
                        />
                        <label>Código Postal *</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email *"
                            aria-label="Email *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="email"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.email"
                            :disabled="status == 'sending'"
                        />
                        <label>Email *</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            name="password"
                            placeholder="Contraseña *"
                            aria-label="Contraseña *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="password"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.password"
                            :disabled="status == 'sending'"
                        />
                        <label>Contraseña *</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Repetir Contraseña *"
                            aria-label="Repetir Contraseña *"
                            aria-describedby="basic-addon1"
                            required="required"
                            autocomplete="password_confirmation"
                            autofocus="autofocus"
                            class="form-control"
                            v-model="input.password_confirmation"
                            :disabled="status == 'sending'"
                        />
                        <label>Repetir Contraseña *</label>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button
                        type="submit"
                        class="btn btn-primary ps-5 pe-5"
                    >
                        Registrarse
                    </button>
                </div>
                <div class="col-md-12 text-end" v-if="app_debug">
                    <button type="button" class="badge bg-secondary" @click="faker()"><i class="fas fa-random"></i></button>
                </div>
            </template>
            <div class="form__overlay" v-if="overlay">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
        </form>
        <div class="row" v-if="componentState == 'registration-completed'">
            <div class="col-md-12">
                <div class="message-container">
                    <i class="far fa-check-circle"></i>
                    <div class="message-text">
                        Registro completado con éxito
                        <br>
                        Debe esperar que tu cuenta sea verificada y activada
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2'
import faker from 'faker'

export default {
	props: {
        endpoint: {}
    },
	components: {},
	data() {
		return {
            componentState: '',
            errors: {},
            status: null,
            locations_1: [],
            locations_2: [],
            type_taxpayer: [],
            overlay: true,
            app_debug: window.app_debug,
			input: {
                username: '',
                full_name: '',
                email: '',
                website: '',
                type_taxpayer_id: null,
                // 
                business_name: '',
                phone: '',
                address: '',
                zip: '',
                dni: '',
                cuit: '',
                location_1_id: null,
                location_2_id: null,
                password: '',
                password_confirmation: '',
            }
		};
	},
    watch: {
        "input.location_1_id": {
            deep: true,
            handler() {
                this.updateSelectLocation2()
            }
        }
    },

	created() {
        this.$nextTick(() => {
            axios.get(this.endpoint + '/api/client/register/data').then((response) => {
                this.locations_1 = response.data.locations_1
                this.locations_2 = response.data.locations_2
                this.type_taxpayer   = response.data.type_taxpayer
                this.input.location_1_id = this.locations_1[0].id
                this.input.type_taxpayer_id = this.type_taxpayer[0].id
                this.overlay = false
            })
        });
	},
	updated: function () {
		this.$nextTick(function () {});
	},
	methods: {
        updateSelectLocation2() {
            const locations_2 = this.filteredLocations2
            this.input.location_2_id = parseFloat(locations_2[0].id)
        },
		async recaptcha() {
            this.errors = {}
            this.overlay = true
			this.saving = 1;
			this.disableddForm = true;
			try {
				// (optional) Wait until recaptcha has been loaded.
				await this.$recaptchaLoaded();

				// Execute reCAPTCHA with action "login".
				const token = await this.$recaptcha("login");
				this.recaptcha_token = token;
			} catch (e) {
				this.saving = 0;
			}
			this.postForm();
		},
		postForm() {
			var form = new FormData();

			form.append("full_name",             this.input.full_name);
			form.append("dni",                   this.input.dni);
			form.append("phone",                 this.input.phone);
			form.append("address",               this.input.address);
			form.append("business_name",         this.input.business_name);
			form.append("zip",                   this.input.zip);
			form.append("type_taxpayer_id",      this.input.type_taxpayer_id);
			form.append("cuit",                  this.input.cuit);
			form.append("location_1_id",         this.input.location_1_id);
			form.append("location_2_id",         this.input.location_2_id);
			form.append("email",                 this.input.email);
			form.append("password",              this.input.password);
			form.append("password_confirmation", this.input.password_confirmation);

			axios.post(this.endpoint + '/api/client/register', form)
            .then((response) => {
                if (response.data.status == 'error') {
                    this.sendError(response.data.errors)
                    return false
                }
                this.errors = {}
                this.overlay = false
                // location.reload()
                this.componentState = 'registration-completed'
			})
            .catch((error) => {
                if (error.response.data.errors) {
                    this.sendError(error.response.data.errors)
                } else {
                    this.sendError({ message: error.response.data.message })
                }
            })
		},
        sendError(errors) {
            this.overlay = false
            this.errors = errors
        },
        faker() {
            faker.locale = "es"
            window.faker = faker
            this.input.full_name             = faker.name.findName()
            // this.input.dni                = faker.random.number(99999999)
            this.input.dni                   = faker.datatype.number({ min: 10000000, max: 99999999 })
            this.input.phone                 = faker.phone.phoneNumber()
            this.input.address               = faker.address.streetAddress()
            this.input.business_name         = faker.company.companyName()
            this.input.zip                   = faker.address.zipCode()
            this.input.cuit                  = window.generateRamdomCuit()
            this.input.email                 = faker.internet.email()
            
            /// let password                 = faker.internet.password()
            this.input.password              = '12345678'
            this.input.password_confirmation = this.input.password
            let key = this.type_taxpayer.length - 1
            key = Math.floor(Math.random() * key - 1) + 1
            this.input.type_taxpayer_id      = this.type_taxpayer[key].id
            key = this.locations_1.length - 1
            key = Math.floor(Math.random() * key - 1) + 1
            this.input.location_1_id         = this.locations_1[key].id
            key = this.filteredLocations2.length - 1
            
            return true
        }
	},
    computed: {
        filteredLocations2: function () {
            return this.locations_2.filter(l => parseFloat(l.location_1_id) === parseFloat(this.input.location_1_id))
        }
    }
};
</script>
<style lang="scss" scoped>
    .badge {
        border: none;
        font-size: 11px;
    }
    .form {
        &__layout {
            position: relative;
            padding-top: 12px;
            padding-bottom: 12px;
        }
        &__overlay {
            position: absolute;
            background-color: #000000;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            justify-content: center;
            align-items: center;
            display: flex;
            color: #FFF;
            font-size: 6em;
            opacity: .3;
        }
    }
.message-container {
    text-align: center;
    padding: 15px 0 15px 0;
    i {
        font-size: 8em;
        color: #b5b5b5;
        margin-bottom: 4px;
        opacity: 0.7;
    }
    .message-text {
        text-align: center;
        font-size: 2em;
        color: #b5b5b5;
        letter-spacing: 2px;
        font-weight: bold;
        .opacity-animation {
            animation: opacity-change 2s infinite;
        }
    }
}
</style>

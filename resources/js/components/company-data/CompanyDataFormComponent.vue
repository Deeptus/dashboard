

<template>
<div class="container">
    <div class="col s12">
        <div class="row justify-content-center" v-if="loaded == 0">
            <h3><center><i class="fas fa-sync fa-spin"></i><br>Cargando</center></h3>
        </div>
        <div class="row justify-content-center" v-if="loaded == 2">
            <h3><center><i class="fas fa-sync fa-spin"></i><br>Guardando</center></h3>
        </div>
        <div class="row justify-content-center" v-if="loaded == 3">
            <div class="col-xl-12 col-md-12 mb-12">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mensaje</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Se ha guardado el <strong>Contenido</strong> con éxito
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="loaded == 1">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Google reCAPTCHA (AntiBots / AntiSpam)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label :for="'config.recaptcha_publickey'">reCAPTCHA public-key</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="'config.recaptcha_publickey'"
                                    :name="'config.recaptcha_publickey'"
                                    v-model="config.recaptcha_publickey"
                                >
                            </div>
                            <div class="form-group col-md-6">
                                <label :for="'config.recaptcha_privatekey'">reCAPTCHA private-key</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="'config.recaptcha_privatekey'"
                                    :name="'config.recaptcha_privatekey'"
                                    v-model="config.recaptcha_privatekey"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Header</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <link-info :model.sync="config.header_networks" :legend="'Social Networks:'"></link-info>
                            </div>

                            <div class="col-md-12">
                                <link-info :model.sync="config.header_info" :legend="'Info:'" :icon="true"></link-info>
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Footer</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <link-info :model.sync="config.footer_networks" :legend="'Social Networks:'"></link-info>
                            </div>

                            <div class="col-md-12">
                                <link-info :model.sync="config.footer_info" :legend="'Info:'" :icon="true"></link-info>
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Contact us</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label :for="'config.contact_target_send_email'">A qué correo electrónico llegarán los mensajes</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    :id="'config.contact_target_send_email'"
                                    :name="'config.contact_target_send_email'"
                                    v-model="config.contact_target_send_email"
                                    placeholder="correo@servidor.com.ar"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tienda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label :for="'config.thousands_separator'">Separador de Miles</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="'config.thousands_separator'"
                                    :name="'config.thousands_separator'"
                                    v-model="config.thousands_separator"
                                >
                            </div>
                            <div class="form-group col-md-6">
                                <label :for="'config.decimal_separator'">Separador de Decimales</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="'config.decimal_separator'"
                                    :name="'config.decimal_separator'"
                                    v-model="config.decimal_separator"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Administrador</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input-file-image2
                                    :model.sync="config.admin_logo"
                                    id="input-logo-header"
                                    label-text="Logo"
                                    label-descript=""
                                ></input-file-image2>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input-file-image2
                                    :model.sync="config.admin_favicon"
                                    id="input-logo-favicon"
                                    label-text="Favicon"
                                    label-descript=""
                                ></input-file-image2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label :for="'config.admin_footer_text'">Pie del ADM</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="'config.admin_footer_text'"
                                    :name="'config.admin_footer_text'"
                                    v-model="config.admin_footer_text"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="loaded == 1">
            <div class="col-xl-12 col-lg-12 d-sm-flex align-items-center justify-content-between">
                <button type="button" @click="postForm()" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm">
                    <i class="fas fa-save fa-sm text-white-50"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    // import ClassicEditor from '@novicov/ckeditor5-build-classic-full';
    import axios from 'axios'
    import LinkInfo from './../LinkInfoComponent'
    import InputFileImage2 from './../InputFileImage2Component';
    import InputFileImage from './../InputFileImageComponent';
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            urlData: '/adm/companydata/api/data',
            urlBack: '/adm/company-data/',
            urlAction: '',
            formName: '',
        },
        components: {
            'link-info': LinkInfo,
            'input-file-image2': InputFileImage2,
            'input-file-image': InputFileImage
        },
        data(){
            return{
                config: {},
                phones: [],
                formData: new FormData(),
                languages: {},
                loaded: 0,
                displayImage: true,
            }
        },
        created() {
            this.$nextTick(() => {
                //console.log(this.urlData)
                axios.get('/adm/companydata/api/data').then((response) => {
                    this.languages = response.data.languages
                    if (response.data.content != null) {
                        this.config = response.data.content
                    }
                    this.loaded = 1
                });
            });
        },
        methods: {
            postForm() {
                this.loaded = 2
                this.loaded = 1
                var form = new FormData();
                /***********************************************/
                let images = [
                    'admin_logo',
                    'admin_favicon',
                    'footer_logo',
                    'header_logo'
                ]
                images.forEach(input => {
                    if (this.config[input]) {
                        if (this.config[input] instanceof File) {
                            form.append(input, this.config[input])
                        }
                        if (this.config[input] instanceof Object && this.config[input].remove) {
                            form.append(input, '--remove--')
                        }
                    }
                })
                let texts = [
                    'thousands_separator',
                    'decimal_separator',
                    'admin_footer_text',
                    'recaptcha_publickey',
                    'recaptcha_privatekey',
                    'comision',
                    'header_networks',
                    'header_info',
                    'footer_networks',
                    'footer_info',
                    'contact_target_send_email',
                ]
                texts.forEach(input => {
                    form.append(input, this.config[input])
                })
                /***********************************************/

                axios.post('/adm/companydata/', form).then((response) => {
                    this.loaded = 3
                    setTimeout(function(){
                        this.loaded = 1
                        //window.location.href = this.urlBack
                    }.bind(this), 1000);
                })
            },
        }
  }
</script>
<style lang="scss" scoped>
    .draggable-item {
        cursor: move;
    }
    .card-header {
        position: relative;
        .card-header-buttons {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            display: flex;
        }
    }
</style>

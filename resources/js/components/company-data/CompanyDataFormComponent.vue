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


<div class="p-grid nested-grid">

        <div class="p-grid">
            <div class="p-col-4">
                <div class="box">

                                <input-file-image2
                                    :model.sync="config.header_logo"
                                    id="input-logo-header"
                                    label-text="Logo Web Superior"
                                    label-descript=""
                                ></input-file-image2>

                </div>
            </div>
            <div class="p-col-4">
                <div class="box">

                                <input-file-image2
                                    :model.sync="config.header_portrait"
                                    id="input-logo-header"
                                    label-text="Fondo portada"
                                    label-descript=""
                                ></input-file-image2>

                </div>
            </div>
            <div class="p-col-4">
                <div class="box">
                                <input-file-image2
                                    :model.sync="config.footer_logo"
                                    id="input-logo-header"
                                    label-text="Logo Web Inferior"
                                    label-descript=""
                                ></input-file-image2>
                </div>
            </div>
           <!--- <div class="p-col-4">
                <div class="box">
                                <input-file-image2
                                    :model.sync="config.admin_favicon"
                                    id="input-logo-favicon"
                                    label-text="Favicon"
                                    label-descript=""
                                ></input-file-image2>
                </div>
            </div> --->
        </div>


                        <div class="p-col-12">
                            <div class="box">
                                <label :for="'config.contact_target_send_email'">A qué correo electrónico llegarán los mensajes ?</label>
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

                            <div class="p-col-12 ">
                                <div class="">
                                <link-info :model.sync="config.header_networks" :legend="'Social Networks'" :icon="true"></link-info>
                                </div>
                            </div>

                            <div class="p-col-12 ">
                                <div class="">
                                <link-info :model.sync="config.footer_info" :legend="'Contacto'" :icon="true" :label="true"></link-info>
                                </div>
                            </div>

</div>



            </div>

        </div>
        <div class="row" v-if="loaded == 1">
            <div class="">
                <Button label="Guardar" type="button" @click="postForm()" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm">                   
                    
                </Button>
            </div>
        </div>
    </div>

</template>

<script>

    import axios from 'axios'
    import LinkInfo from './../LinkInfoComponent'
    import InputFileImage2 from './../InputFileImage2Component';
    import InputFileImage from './../InputFileImageComponent';
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            urlData: '/adm/company-data/api/data',
            urlBack: '/adm/company-data/',
            urlAction: '/adm/company-data/update',
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

            console.log('wololo')
            this.$nextTick(() => {
                //console.log(this.urlData)
                axios.get('/adm/company-data/api/data').then((response) => {
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
                    'header_portrait',
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

                axios.post('/adm/company-data/update', form).then((response) => {
                    this.loaded = 3
                    setTimeout(function(){
                        this.loaded = 1
                        console.log(response)
                    }.bind(this), 1000);
                })
            },
        }
  }
</script>
<style lang="scss">

.box {
    background-color: var(--surface-e);
    text-align: center;
    padding-top: 1rem;
    padding-bottom: 1rem;
    border-radius: 4px;
    -webkit-box-shadow: 0 2px 1px -1px rgba(0,0,0,.2),0 1px 1px 0 rgba(0,0,0,.14),0 1px 3px 0 rgba(0,0,0,.12);
    box-shadow: 0 2px 1px -1px rgba(0,0,0,.2),0 1px 1px 0 rgba(0,0,0,.14),0 1px 3px 0 rgba(0,0,0,.12);
}

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

    .flexgrid-demo {
    .box {
        background-color: var(--surface-e);
        text-align: center;
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-radius: 4px;
        box-shadow: 0 2px 1px -1px rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 1px 3px 0 rgba(0,0,0,.12);
    }

    .box-stretched {
        height: 100%;
    }

    .vertical-container {
        margin: 0;
        height: 200px;
        background: var(--surface-d);
        border-radius: 4px;
    }

    .nested-grid .p-col-4 {
        padding-bottom: 1rem;
    }

    .dynamic-box-enter-active, .dynamic-box-leave-active {
        transition: all .5s;
    }

    .dynamic-box-enter, .dynamic-box-leave-to {
        opacity: 0;
    }

    .dynamic-box-enter, .dynamic-box-leave-to {
        transform: translateX(30px);
    }

    p {
        margin: 0;
    }
}

</style>

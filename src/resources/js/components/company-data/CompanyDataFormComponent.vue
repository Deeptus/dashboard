<template>
<div class="row">
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
                        <h6 class="m-0 font-weight-bold text-primary">IMÁGENES</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input-file-image
                                    :model.sync="logoHeader"
                                    id="input-logo-header"
                                    label-text="Seleccione Logotipo"
                                ></input-file-image>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input-file-image
                                    :model.sync="logoFooter"
                                    id="input-logo-footer"
                                    label-text="Seleccione Logotipo Footer"
                                ></input-file-image>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <input-file-image
                                    :model.sync="logoFavicon"
                                    id="input-logo-favicon"
                                    label-text="Seleccione Favicon"
                                ></input-file-image>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Teléfonos</h6>
                        <div class="card-header-buttons">
                            <button type="button" class="btn btn-info" @click="addPhone()">
                                <i class="fas fa-plus"></i>
                                Añadir
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <draggable v-model="phones" class="row" draggable=".draggable-item" @change="log">
                            <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in phones" :key="index">
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <select class="form-control" v-model="item.type">
                                                <option value="tel">Teléfono</option>
                                                <option value="cel">Celular</option>
                                                <option value="wha">Whatsapp</option>
                                            </select>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" id="basic-addon1" v-if="item.type == 'tel'">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                    <div class="input-group-text" id="basic-addon1" v-else-if="item.type == 'cel'">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </div>
                                                    <div class="input-group-text" id="basic-addon1" v-else-if="item.type == 'wha'">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </div>
                                                </div>
                                                <input v-model="item.numero" type="text" class="form-control" placeholder="1112345678">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </draggable>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Email</h6>
                        <div class="card-header-buttons">
                            <button type="button" class="btn btn-info" @click="addEmail()">
                                <i class="fas fa-plus"></i>
                                Añadir
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <draggable v-model="emails" class="row" draggable=".draggable-item" @change="log">
                            <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in emails" :key="index">
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" id="basic-addon1">
                                                        <i class="fas fa-mail-bulk"></i>
                                                    </div>
                                                </div>
                                                <input v-model="item.email" type="email" class="form-control" placeholder="ingrese@email">
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input
                                                type="checkbox"
                                                v-bind:true-value="1"
                                                v-bind:false-value="0"
                                                v-model.number="item.notify_contact"
                                                class="custom-control-input"
                                                :id="'notify_contact'+index"
                                                >
                                                <label class="custom-control-label" :for="'notify_contact'+index">Se le notifica cuando se envie un mensaje en la sección contacto</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </draggable>
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
    import draggable from 'vuedraggable'
    import InputFileImage from '../InputFileImageComponent';
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            urlData: '',
            urlBack: '',
            urlAction: '',
            formName: '',
        },
        components: {
            draggable,
            'input-file-image': InputFileImage
        },
        data(){
            return{
                logoHeader: '',
                logoFooter: '',
                logoFavicon: '',
                phones: [],
                emails: [],
                formData: new FormData(),
                languages: {},
                loaded: 0,
                displayImage: true,
            }
        },
        created() {
            this.$nextTick(() => {
                console.log(this.urlData)
                axios.get(this.urlData).then((response) => {
                    this.languages = response.data.languages
                    if (response.data.content != null) {
                        this.content = response.data.content
                    }
                    this.loaded = 1
                });
            });
        },
        methods: {
            postForm() {
                console.log(this.logoHeader)
            },
            addPhone() {
                this.phones.push({
                    type: 'tel',
                    numero: ''
                });
            },
            addEmail() {
                this.emails.push({
                    email: '',
                    notify_contact: 0
                });
            },
            log() {

            }
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

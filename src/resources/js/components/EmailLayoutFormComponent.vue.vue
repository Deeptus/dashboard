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
                            <h6 class="m-0 font-weight-bold text-primary">{{ formName }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="key">Key</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="key"
                                        v-model="content.key"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="description"
                                        v-model="content.description"
                                    >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="subject">Subject</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="subject"
                                        v-model="content.subject"
                                    >
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-md-12">
                                    <label for="body">Body - <small>No se recomienda copiar y pegar desde word, excel, etc.</small></label>
                                    <jodit-vue
                                        v-model="content.body"
                                        :buttons="jodit.buttons"
                                        id="body"
                                    ></jodit-vue>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="loaded == 1">
                <div class="col-xl-12 col-lg-12 d-sm-flex align-items-center justify-content-between">
                    <a :href="urlBack" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                        <i class="fas fa-step-backward fa-sm text-white-50"></i>
                        Volver Atras
                    </a>

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
    import CustomGallery from './CustomGalleryComponent'
    import 'jodit/build/jodit.min.css'
    import { JoditEditor } from 'jodit-vue'
    import draggable from 'vuedraggable'
    import fichas from './FichaComponent'

    var publicPATH = document.head.querySelector('meta[name="public-path"]').content
    export default {
        props: {
            urlData: '',
            urlBack: '',
            urlAction: '',
            formName: '',
        },
        components: {
            'jodit-vue': JoditEditor,
            'custom-gallery': CustomGallery,
            draggable,
            fichas,
        },
        data(){
            return{
                config: {},
                content: {
                    key: '',
                    description: '',
                    subject: '',
                    body: '',
                },
                jodit: {
                    buttons: []
                },
                formData: new FormData(),
                languages: {},
                defaultLang: '',
                loaded: 0,
                backendErrors: [],
            }
        },
        created() {
            this.$nextTick(() => {
                this.jodit.buttons = [
                    'source', '|',
                    {
                        group: 'font-style',
                        buttons: [
                            'link'
                        ]
                    },
                    '|',
                    {
                        name: 'Copiar',
                        exec: function (editor) {
                            if (editor.selection.isCollapsed()) {
                                editor.execCommand('selectall');
                            }
                            editor.execCommand('copy');
                            Jodit.Alert('Text in your clipboard');
                        }
                    },
                    {
                        name: 'Pegar',
                        exec: function (editor) {
                            editor.execCommand('paste');
                        }
                    },
                    '\n',
                    {
                        name: 'Nombre del Cliente',
                        exec: function (editor) {
                            editor.selection.insertHTML('_client_fullname_');
                        }
                    },
                    {
                        name: 'Pedido ID',
                        exec: function (editor) {
                            editor.selection.insertHTML('_purchase_id_');
                        }
                    },
                    {
                        name: 'Pedido OCA Orden Retiro',
                        exec: function (editor) {
                            editor.selection.insertHTML('_purchase_oca_ingreso_orden_retiro_');
                        }
                    },
                    {
                        name: 'Tabla de Items',
                        exec: function (editor) {
                            editor.selection.insertHTML('_component_items_');
                        }
                    }
                ]
                axios.get(this.urlData).then((response) => {
                    this.config      = response.data.config
                    this.languages   = response.data.languages

                    this.defaultLang = Object.keys(this.languages)[0]
                    if (
                        response.data.content != null
                        && Object.prototype.toString.call( response.data.content ) == '[object Object]'
                    ) {
                        this.content = response.data.content
                    }
                    this.loaded        = 1
                })
            })
        },
        updated: function () {
            this.$nextTick(function () {
                /*$('.custom-file-input').on('change', function() {
                    let fileName = $(this).val().split('\\').pop()
                    $(this).next('.custom-file-label').addClass("selected").html(fileName)
                })*/
            })
        },
        methods: {
            postForm() {
                this.loaded = 2
                var form = new FormData()
                if (this.content.image) {
                    if (this.content.image instanceof File) {
                        form.append('image', this.content.image)
                    }
                    if (this.content.image instanceof Object && this.content.image.remove) {
                        form.append('image', '--remove--')
                    }
                }
                form.append('key',         this.content.key)
                form.append('description', this.content.description)
                form.append('subject',     this.content.subject)
                form.append('body',        this.content.body)
                axios.post(this.urlAction, form).then((response) => {
                    if (response.data.status == 'error') {
                        this.backendErrors = response.data.errors
                        this.loaded = 1
                    }
                    if (response.data.status == 'success') {
                        this.loaded = 3
                        setTimeout(() => {
                            window.location.href = this.urlBack
                        }, 1000)
                    }
                })
                .catch((error) => {
                    // handle error
                    this.loaded = 1
                    console.log('error')
                    // console.log(error)
                })
                .then(() => {
                    console.log('siempre')
                    // always executed

                })
                //this.loaded = 1
            },
            addNewSize() {
                this.colors.forEach(color => {
                    this.$set(this.presentations, color+'-'+this.newSize, {
                        id: 0,
                        color_name: color,
                        size: this.newSize,
                        suggested_price: 0,
                        front_model_image_url: "",
                        back_model_image_url: "",
                        front_flat_image_url: "",
                        back_flat_image_url: ""
                    })
                })
                this.sizes.push(this.newSize)
                this.newSize = ''
            },
            addNewColor() {
                this.sizes.forEach(size => {
                    this.$set(this.presentations, this.newColor+'-'+size, {
                        id: 0,
                        color_name: this.newColor,
                        size: size,
                        suggested_price: 0,
                        front_model_image_url: "",
                        back_model_image_url: "",
                        front_flat_image_url: "",
                        back_flat_image_url: ""
                    })
                })
                this.colors.push(this.newColor)
                this.newColor = ''
            },
            removeColor(index) {
                let deleteColor = this.colors.splice(index, 1)[0]
                if (this.selectedColor == deleteColor) {
                    if (this.colors.length) {
                        this.selectedColor = this.colors[0]
                    }
                }
                if (!this.colors.length) {
                    this.selectedColor = ''
                }
                this.sizes.forEach(size => {
                    delete this.presentations[deleteColor+'-'+size]
                })
            },
            selectImage(color, size, col) {
                this.selectImageData = {
                    color: color,
                    size: size,
                    col: col
                }
                this.$refs.fileSelectImage.click()
            },
            getPreviewImage(file) {
                let imgExt = ['image/jpeg', 'image/png', 'image/x-icon', 'image/svg+xml', 'image/svg']
                if (imgExt.includes(file.type)) {
                    if (file && file instanceof File) {
                        return URL.createObjectURL(file)
                    }
                    if (typeof file === 'object' || file instanceof Object) {
                        return file.url
                    }
                }
            },
            onFileChange(e) {
                let file = e.target.files[0]
                this.image = file
                this.$set(this.presentations[this.selectImageData.color+'-'+this.selectImageData.size], this.selectImageData.col, this.getPreviewImage(file))
            }
        }
  }
</script>
<style lang="scss" scoped>
    .gallery-item {
        position: relative;
        width: 100%;
        margin-bottom: 5px;
    }
    .gallery-item-controls {
        position: absolute;
        right: 0;
        top: 0;
    }
    .gallery-item-container{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2px;
        border: solid 1px #CCC;
        img {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .gallery-item-overlay {
        padding-bottom: 100%;
    }
    .draggable-item {
        cursor: move;
        overflow: hidden;
        &:hover .gallery-item-path {
            bottom: 0;
            margin-top: 0;
        }
    }
    .image-selector {
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
        cursor: pointer;
        position: relative;
        font-weight: 900;
        font-family: "Font Awesome 5 Free";
        font-size: 2em;
        color: #FFF;
        &:hover::before {
            content: "\f87c";
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, .3);
            position: absolute;
            justify-content: center;
            align-items: center;
            display: flex;
        }
    }
</style>

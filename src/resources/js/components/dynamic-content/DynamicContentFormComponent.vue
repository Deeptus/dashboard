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
                        <fieldset v-if="config['choose-lang']">
                            <legend>Seleccione Idiomas</legend>
                            <div class="row">
                                <div class="input-group col-md-3 mb-3" v-for="(languageKey, index) in getLanguages()" :key="index">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" :id="'lang-'+languageKey" :value="languageKey" v-model="content.lang" :aria-label="languages[languageKey]">
                                        </div>
                                    </div>
                                    <label :for="'lang-'+languageKey" class="form-control">{{ languages[languageKey] }}</label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset v-for="(languageKey, index) in content.lang" :key="index">
                            <legend>{{ languages[languageKey] }}</legend>
                            <div class="row" v-if="isDisplayInput('use-order', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'order-'+languageKey">{{ getLabel('use-order')?getLabel('use-order'):'Orden' }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'order-'+languageKey"
                                        :name="'order-'+languageKey"
                                        v-model="content.order[languageKey]"
                                    >
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-url', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'url-'+languageKey">{{ getLabel('use-url') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'url-'+languageKey"
                                        :name="'url-'+languageKey"
                                        v-model="content.url[languageKey]"
                                    >
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-title', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'title-'+languageKey">{{ getLabel('use-title') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'title-'+languageKey"
                                        :name="'title-'+languageKey"
                                        v-model="content.title[languageKey]"
                                        v-if="!wysiwyg('use-title')"
                                    >
                                    <jodit-vue
                                        v-model="content.title[languageKey]"
                                        :id="'title-'+languageKey"
                                        :value="content.title[languageKey]"
                                        v-else
                                    ></jodit-vue>
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-subtitle', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'subtitle-'+languageKey">{{ getLabel('use-subtitle') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'subtitle-'+languageKey"
                                        :name="'subtitle-'+languageKey"
                                        v-model="content.subtitle[languageKey]"
                                        v-if="!wysiwyg('use-subtitle')"
                                    >
                                    <jodit-vue
                                        v-model="content.subtitle[languageKey]"
                                        :id="'subtitle-'+languageKey"
                                        :value="content.subtitle[languageKey]"
                                        v-else
                                    ></jodit-vue>
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-text', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'text-'+languageKey">{{ getLabel('use-text') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'text-'+languageKey"
                                        :name="'text-'+languageKey"
                                        v-model="content.text[languageKey]"
                                        v-if="!wysiwyg('use-text')"
                                    >
                                    <jodit-vue
                                        v-model="content.text[languageKey]"
                                        :id="'text-'+languageKey"
                                        :value="content.text[languageKey]"
                                        v-else
                                    ></jodit-vue>
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-description', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'description-'+languageKey">{{ getLabel('use-description') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        :id="'description-'+languageKey"
                                        :name="'description-'+languageKey"
                                        v-model="content.description[languageKey]"
                                        v-if="!wysiwyg('use-description')"
                                    >
                                    <jodit-vue
                                        v-model="content.description[languageKey]"
                                        :id="'description-'+languageKey"
                                        :value="content.description[languageKey]"
                                        v-else
                                    ></jodit-vue>
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-date', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'date-'+languageKey">{{ getLabel('use-date') }}</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        :id="'date-'+languageKey"
                                        :name="'date-'+languageKey"
                                        v-model="content.date"
                                    >
                                </div>
                            </div>
                            <div class="row" v-if="isDisplayInput('use-featured', languageKey)">
                                <div class="form-group col-md-12">
                                    <label :for="'featured-'+languageKey">{{ getLabel('use-featured') }}</label>
                                    <select
                                        class="form-control"
                                        :id="'featured-'+languageKey"
                                        :name="'featured-'+languageKey"
                                        v-model="content.featured"
                                    >
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group" v-if="isDisplayInput('use-image', languageKey)">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" :for="'image-'+languageKey" id="inputGroupFileAddon01"><i class="fas fa-2x fa-images"></i></label>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" :id="'image-'+languageKey"  @change="onFileChange($event, languageKey)" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" :for="'image-'+languageKey" aria-label="test">
                                        <img :src="getPreviewImage(languageKey)" v-if="displayImage" style="max-height: 100%;">
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div v-if="!$root.checkValidFileSize(content.image[languageKey])" style="color: #FC3939; font-weight: bold; font-size: .9em;">El Archivo pesa mas de lo permitido, peso maximo permitido: <strong>{{ $root.getValidFileSize('h') }}</strong></div>
                            </div>
                            <fieldset v-if="isDisplayInput('use-gallery', languageKey)" @dragover="onDropGalleryOver" @drop="onDropGallery">
                                <legend>{{ getLabel('use-gallery') }}</legend>
                                    <draggable v-model="content.gallery" class="row" draggable=".item" @change="log">
                                        <div class="col-md-3 item" v-for="(item, index) in content.gallery" :key="index">
                                            <div class="gallery-item draggable-item" for="inputgallery">
                                                <div class="gallery-item-overlay"></div>
                                                <div class="gallery-item-container">
                                                    <img :src="createImageURL(item)" alt="">
                                                </div>
                                                <div class="gallery-item-controls">
                                                    <button type="button" class="btn btn-danger" @click="deleteFileGallery(index)"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div slot="footer" class="col-md-3">
                                            <label class="gallery-item" for="inputgallery">
                                                <input type="file" id="inputgallery" class="d-none" @change="onFileGallery($event)" multiple>
                                                <div class="gallery-item-overlay"></div>
                                                <div class="gallery-item-container">
                                                    <div class="gallery-item-container">
                                                        <span class="text-center">
                                                            <i class="fas fa-upload fa-5x"></i>
                                                            <br>
                                                            Selccionar
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </draggable>
                            </fieldset>
                        </fieldset>
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
    import draggable from 'vuedraggable'
    import 'jodit/build/jodit.min.css'
    import { JoditEditor } from 'jodit-vue'
    import Swal from 'sweetalert2'

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
            'jodit-vue': JoditEditor,
        },
        data(){
            return{
                config: {},
                content: {
                    lang: [],
                    order: {},
                    url: {},
                    title: {},
                    subtitle: {},
                    text: {},
                    description: {},
                    image: {},
                    date: '',
                    featured: 0,
                    gallery: [],
                },
                languages: {},
                loaded: 0,
                displayImage: true,
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.config  = response.data.config
                    this.languages = response.data.languages
                    if (response.data.content != null) {
                        this.content = response.data.content
                    }
                    if (this.content.lang.length == 0) {
                        this.content.lang = Object.keys(response.data.languages)
                    }
                    this.loaded = 1
                });
            });
        },
        methods: {
            onDropGalleryOver(e) {
                var path = e.path || (e.composedPath && e.composedPath())
                e.preventDefault()
                if (e.dataTransfer.effectAllowed != 'move') {
                    path.every(function (element) {
                        if (element.localName == 'fieldset') {
                            element.style.backgroundColor = "#dedede"
                            return false
                        }
                        return true
                    })
                }
            },
            onDropGallery(e) {
                var path = e.path || (e.composedPath && e.composedPath())
                e.preventDefault();
                path.every(function (element) {
                    if (element.localName == 'fieldset') {
                        element.style.backgroundColor = ""
                        return false
                    }
                    return true
                })
                for (let index = 0; index < e.dataTransfer.files.length; index++) {
                    this.content.gallery.push(e.dataTransfer.files[index])
                }
                return true
            },
            log() {
                console.log(this.content.gallery)
            },
            // Extrae las propiedades de un Input
            getProperty(input, position) {
                return parseInt(this.config[input].properties.toString().split("")[position])
            },
            // Extrae el nombre del Input
            getLabel(input) {
                return this.config[input].label
            },
            wysiwyg(input) {
                if (this.config[input].wysiwyg) {
                    return true
                }
                return false
            },
            isDisplayInput(input, language) {
                let display = false

                // Se verifica si no es false
                if(!this.config[input])
                    return false

                // Se verifica si el campo se mostrara
                // 100 Se muestra
                //  10 Se traduce
                //   1 Es Requerido
                if (this.getProperty(input, 0) == 1) {
                    display = true
                }

                // Se verifica si el campo se mostrara para el idioma en específico
                if (display && (this.getProperty(input, 1) || language == this.getLanguages()[0])) {
                    return true
                }
                return false
            },
            postForm() {
                // this.loaded = 2
                let formData = new FormData()
                if (this.content.image) {
                    Object.keys(this.content.image).forEach((key) => {
                        formData.append('images['+key+']', this.content.image[key]);
                    })
                }
                if (this.content.gallery) {
                    Object.keys(this.content.gallery).forEach((key) => {
                        let file = this.content.gallery[key]
                        if (file && file instanceof File) {
                            formData.append('gallery['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            formData.append('gallery['+key+']', file);
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            formData.append('gallery['+key+']', file.path);
                        }
                    })
                }
                formData.append('data', JSON.stringify(this.content));

                let formTotalSize = 0
                for(var pair of formData.entries()) {
                    if (pair[1] instanceof Blob) 
                        formTotalSize += pair[1].size;
                    else
                        formTotalSize += pair[1].length;
                }
                formTotalSize = formTotalSize / 1024
                if (formTotalSize>this.$root.getPostMaxSize()) {
                    Swal.fire({
                        title: 'No se puede enviar',
                        type: 'error',
                        // width: 600,
                        html: '<div style="text-align: center;">El Formulario que desea enviar pesa mas de lo permitido, peso maximo permitido: <strong>' + this.$root.getPostMaxSize('h') + '</strong></div>',
                        confirmButtonText: 'Cerrar',
                    })
                    return false
                }

                axios.post(this.urlAction, formData).then((response) => {
                    this.loaded = 3
                    var self = this
                    setTimeout(() => {
                        window.location.href = this.urlBack
                    }, 1000);
                });
            },
            getLanguages: function () {
                var self = this
                var languagesKey = [];
                Object.keys(self.languages).forEach(function(key){
                    // self.languages[key]
                    languagesKey.push(key)
                })
                return languagesKey
            },
            onFileChange(e, languageKey) {
                this.displayImage = false
                const file = e.target.files[0];
                this.content.image[languageKey] = file
                this.displayImage = true
            },
            onFileGallery(e){
                for (let index = 0; index < e.target.files.length; index++) {
                    this.content.gallery.push(e.target.files[index])
                }
                return true
            },
            createImageURL(file){
                if (file && file instanceof File) {
                    return URL.createObjectURL(file)
                }
                if (typeof file === 'string' || file instanceof String) {
                    return file
                }
                if (typeof file === 'object' || file instanceof Object) {
                    return file.url
                }
            },
            getPreviewImage(languageKey) {
                let image = this.content.image[languageKey]
                if (image && image instanceof File) {
                    return URL.createObjectURL(image)
                }
                if (typeof image === 'string' || image instanceof String) {
                    return image
                }
            },
            deleteFileGallery(index) {
                this.content.gallery.splice(index, 1);
            }
        }
  }
</script>
<style lang="scss" scoped>
    .custom-file-label {
        height: 100px;
    }
    .custom-file-label::after {
        content: "Seleccione Archivo" !important;
        height: auto !important;
        justify-content: center;
        align-items: center;
        display: flex;
    }
    .custom-file {
        height: 100px !important;
    }
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
    }
</style>

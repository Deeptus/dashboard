<template>
    <fieldset @dragover="onDropGalleryOver" @drop="onDropGallery">
        <legend v-if="label">{{ label }}</legend>
            <draggable v-model="gallery" class="row" draggable=".item">
                <div class="col-12 col-md-12 col-lg-6" :class="{ 'item': !readonly }" v-for="(item, index) in gallery" :key="index">
                    <div class="gallery-item draggable-item" :class="{ 'cursor-move': !readonly }" :for="id">
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-controls">
                            <div class="gallery-item-preview">
                                <img :src="createImageURL(item)" alt="">
                            </div>
                            <div class="gallery-item-path">
                                {{ createImageName(item) }}
                                <span :href="itemURL(item)" target="_blank" :class="{ 'text-success': fileInfo(item).valid, 'text-danger': !fileInfo(item).valid }" v-if="fileInfo(item).location == 'fileToUpload'">{{ fileInfo(item).sizeH }}</span>
                            </div>
                            <button type="button" class="btn btn-primary" @click="btnEdit(item)" v-if="!readonly"><i class="fas fa-edit"></i></button>
                            <a :href="itemURL(item)" target="_blank" class="btn btn-primary btn-download"><i class="fas fa-download"></i></a>
                            <button type="button" class="btn btn-danger" @click="deleteFileGallery(index)" v-if="!readonly"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div slot="footer" class="col-12 col-md-12 col-lg-6" v-if="!readonly && enabled()">
                    <label class="gallery-item cursor-pointer" :for="id" v-if="useFileManager == false">
                        <input type="file" :id="id" class="d-none" @change="onFileGallery($event)" multiple>
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-container">
                            <span class="gallery-item-add">
                                <i class="fas fa-upload me-3"></i>
                                Seleccionar
                            </span>
                        </div>
                    </label>
                    <div class="gallery-item cursor-pointer" v-else @click="selectFile()">
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-container">
                            <span class="gallery-item-add">
                                <i class="fas fa-upload me-3"></i>
                                Seleccionar
                            </span>
                        </div>
                    </div>
                </div>
            </draggable>
    </fieldset>
</template>
<script>
    import draggable from 'vuedraggable'
    import edit from './edit.vue'
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            model: {
                default: []
            },
            label: {
                type: String,
                default: null,
            },
            max: {
                type: Number,
                default: null,
            },
            useFileManager: {
                type: Boolean,
                default: false
            },
            readonly: {
                type: Boolean,
                default: false
            },
            enableEdit: {
                type: Object,
                default: function () {
                    return { original_name: true, caption: true }
                }
            },
        },
        components: {
            draggable,
        },
        data(){
            return{
                gallery: [],
                id: ''
            }
        },
        created() {
            let model = []
            if (Object.prototype.toString.call( this.model ) == '[object Object]') {
                if (this.model.value) {
                    model = this.model.value
                } else {
                    model = Object.values(this.model)
                }
            }
            if (Object.prototype.toString.call( this.model ) == '[object Array]') {
                model = this.model
            }
            this.gallery = JSON.parse(JSON.stringify(model || []))
        },
        mounted () {
            this.id = this._uid.toString() + Math.random().toString(36).substring(2)
        },
        watch: {
            gallery: function(val, oldVal) {
                let gallerySize = 0
                let errors = {
                    ok: true,
                    filesThatExceed: 0,
                    gallerySizeExceeded: false
                }
                this.gallery.forEach(item => {
                    if (item instanceof File) {
                        gallerySize += this.getFileSize(item)
                        if (!this.checkValidFileSize(item)) {
                            errors.ok = false
                            errors.filesThatExceed++
                        }
                    }
                });
                if (gallerySize > this.getPostMaxSize()) {
                    errors.ok = false
                    errors.gallerySizeExceeded = true
                }
                if (Object.prototype.toString.call( this.model ) == '[object Object]') {
                    // this.$emit('errors', errors)
                    // this.$emit('update:model', { value: this.gallery, errors: errors })
                    this.model.value  = this.gallery
                    this.model.errors = errors
                } else {
                    this.$emit('errors', errors)
                    this.$emit('update:model', this.gallery || [])
                }
            }
        },
        methods: {
            enabled() {
                if (this.max && this.gallery.length >= this.max) {
                    return false
                }
                return true
            },
            btnEdit(item) {
                am().openModal(edit, { item, enableEdit: this.enableEdit }).then( response => {
                    item.medicion_fecha.push(response)
                    if (item.step < 1.3) {
                        item.step = 1.3
                    }
                    setTimeout(() => {
                        this.state = 'display'
                    }, 500)
                }).catch((error) => {
                    this.state = 'display'
                })

            },
            async selectFile() {
                var ids = this.gallery.map((a) => a.id)
                await this.fileManager().open({ excludeIds: ids }).then((callback) => {
                    this.image = {}
                    if (callback) {
                        this.gallery.push({
                            id:   callback.id,
                            path: callback.path,
                            type: callback.type,
                            url:  callback.url
                        })
                        // console.log(this.gallery)
                        /*
                        this.$set(this.image, 'id',   callback.id)
                        this.$set(this.image, 'path', callback.path)
                        this.$set(this.image, 'type', callback.type)
                        this.$set(this.image, 'url',  callback.url)
                        */
                    }
                })
            },
            fileInfo(item) {
                let info = {}
                if (item.file instanceof File) {
                    info = {
                        location: 'fileToUpload',
                        size: this.getFileSize(item.file),
                        valid: this.checkValidFileSize(item.file),
                        sizeH: this.getFileSize(item.file, 'h')
                    }
                    return info
                }
                return { location: 'inServer' }
            },
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
                    this.gallery.push(e.dataTransfer.files[index])
                }
                return true
            },
            onFileGallery(e){
                for (let index = 0; index < e.target.files.length; index++) {
                    if (this.gallery.length < this.max) {
                        this.gallery.push({
                            info: {
                                alt : '',
                                caption : '',
                                original_name: e.target.files[index].name
                            },
                            file: e.target.files[index]
                        })
                    }
                    if (this.max == null) {
                        this.gallery.push({
                            info: {
                                alt : '',
                                caption : '',
                                original_name: e.target.files[index].name
                            },
                            file: e.target.files[index]
                        })
                    }
                }
                return true
            },
            getFileIcon(file) {
                // Este metodo deberia encargarse se sacar las preview de imagenes y pdf
                // Este metodo deberia ser global o una libreria independiente
                let icon = false
                let fileIcon = [
                    {
                        ext: [
                            'application/zip',
                            'application/x-zip-compressed'
                        ],
                        icon: publicPATH + '/images/icons/zip.svg'
                    },
                    {
                        ext: [
                            'application/pdf'
                        ],
                        icon: publicPATH + '/images/icons/pdf.svg'
                    },
                    {
                        ext: [
                            'text/csv',
                            'text/xml',
                            'text/plain'
                        ],
                        icon: publicPATH + '/images/icons/txt.svg'
                    },
                    {
                        ext: [
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel'
                        ],
                        icon: publicPATH + '/images/icons/xls.svg'
                    },
                    {
                        ext: [
                            'application/msword'
                        ],
                        icon: publicPATH + '/images/icons/doc.svg'
                    },
                ]
                fileIcon.forEach(item => {
                    if (item.ext.includes(file.type)) {
                        icon = item.icon
                    }
                });
                return icon
            },
            createImageURL(file){
                if (file.file) {
                    file = file.file
                }
                if (!file.type) {
                    return ''
                }

                let icon = this.getFileIcon(file)
                if (icon) {
                    return icon
                }

                let imgExt = ['image/jpeg', 'image/png']
                if (imgExt.includes(file.type)) {
                    if (file && file instanceof File) {
                        return URL.createObjectURL(file)
                    }
                    if (typeof file === 'object' || file instanceof Object) {
                        return file.url
                    }
                }
                return publicPATH + '/images/icons/raw.svg'
                if (typeof file === 'string' || file instanceof String) {
                    return this.storage_path(file)
                }
            },
            createImageName(file) {
                if (file.file) {
                    file = file.file
                } else {
                    file = file.original_name
                }
                if (file && file instanceof File) {
                    return file.name
                }
                if (typeof file === 'string' || file instanceof String) {
                    return file.split('/').pop()
                }
                if (typeof file === 'object' || file instanceof Object) {
                    if(file.url) {
                        return file.url.split('/').pop()
                    }
                }
            },
            deleteFileGallery(index) {
                this.gallery.splice(index, 1);
            },
            itemURL(file) {
                if (typeof file === 'object' || file instanceof Object) {
                    if (file.file && file.file instanceof File) {
                        return URL.createObjectURL(file.file)
                    }
                    return file.url
                }
            }
        },
        computed: {
        }
    }
</script>
<style lang="scss" scoped>
    .gallery-item {
        position: relative;
        width: 100%;
        margin-bottom: 5px;
        user-select: none;
        background-color: #e4e4e4;
        &:hover {
            background: #c6e7ff;
        }
    }
    .gallery-item-controls {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        height: 100%;
        border: 2px solid #b0bdc7;
        .btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }
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
        border: 2px solid #b0bdc7;
        img {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .gallery-item-preview {
        height: 55px;
        width: 55px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2px;
        img {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .gallery-item-add {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
    }
    .gallery-item-overlay {
        padding-bottom: 55px;
    }
    .gallery-item-path {
        flex: 1;
        padding: 5px 0;
    }
    .cursor-move {
        cursor: move;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .draggable-item {
        overflow: hidden;
        &:hover .gallery-item-path {
            bottom: 0;
            margin-top: 0;
        }
    }
    .btn-download {
        pointer-events: auto;
    }
</style>

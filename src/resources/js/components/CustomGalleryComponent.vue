<template>
    <fieldset @dragover="onDropGalleryOver" @drop="onDropGallery">
        <legend>{{ label }}</legend>
            <draggable v-model="gallery" class="row" draggable=".item">
                <div class="col-md-3 item" v-for="(item, index) in gallery" :key="index">
                    <div class="gallery-item draggable-item" :for="id">
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-container">
                            <img :src="createImageURL(item)" alt="">
                        </div>
                        <div class="gallery-item-controls">
                            <button type="button" class="btn btn-danger" @click="deleteFileGallery(index)"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        <div class="gallery-item-path">
                            {{ createImageName(item) }}
                        </div>
                    </div>
                </div>
                <div slot="footer" class="col-md-3">
                    <label class="gallery-item" :for="id">
                        <input type="file" :id="id" class="d-none" @change="onFileGallery($event)" multiple>
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
</template>
<script>
    import draggable from 'vuedraggable'
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            model: {
                type: Array,
            },
            label: {
                type: String,
                default: 'Fotos del Producto'
            },
            /*id: {
                type: String,
                default: ''
                // default: Math.random().toString(36).substring(2)
            },*/
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
            this.gallery = JSON.parse(JSON.stringify(this.model || []))
        },
        mounted () {
            this.id = this._uid.toString() + Math.random().toString(36).substring(2)
        },
        watch: {
            gallery: function(val, oldVal) {
                this.$emit('update:model', this.gallery || [])
            }
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
                    this.gallery.push(e.dataTransfer.files[index])
                }
                return true
            },
            onFileGallery(e){
                for (let index = 0; index < e.target.files.length; index++) {
                    this.gallery.push(e.target.files[index])
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
    .gallery-item-path {
        position: absolute;
        width: 100%;
        font-size: 12px;
        line-height: 14px;
        border-top: 1px solid #000;
        padding: 2px 5px 4px 5px;
        background-color: #00000085;
        color: aliceblue;
        transition: .2s bottom;
    }
    .draggable-item {
        cursor: move;
        overflow: hidden;
        &:hover .gallery-item-path {
            bottom: 0;
            margin-top: 0;
        }
    }
</style>
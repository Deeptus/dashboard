<template>
    <div class="card">
        <div class="preview-image">
            <div class="preview-image-empty"></div>
            <div class="preview-image-container" v-if="displayImage">
                <img :src="getPreviewImage()">
            </div>
            <div class="preview-image-container unselected" v-else>
                <div class="unselected-text">
                    <i class="far fa-2x fa-file-image"></i><br>
                    Imagen no Disponible
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ labelText }}</h5>
            <label class="btn btn-block btn-light">
                <input type="file" class="d-none" @change="onFileChange($event)">
                <i class="fas fa-images"></i>
                Seleccionar Imagen
            </label>
        </div>
    </div>
</template>
<script>
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: ['model','id', 'labelText'],
        data(){
            return{
                displayImage: false,
                image: '',
            }
        },
        created() {
        },
        mounted () {
            this.image = this.model
            this.displayImage = true
        },
        watch: {
            model: function(val, oldVal) {
                this.image = val
                this.displayImage = true
            },
            image: function(val, oldVal) {
                this.$emit('update:model', this.image || [])
            }
        },
        methods: {
            onFileChange(e) {
                this.displayImage = false
                let file = e.target.files[0];
                this.image = file
                this.$emit('update:model', file)
                this.displayImage = true
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
            getPreviewImage() {
                let file = this.image

                if (!this.$root.checkValidFileSize(file)) {
                    return publicPATH + '/images/icons/Emblem-important-red.svg'
                }

                if (!file || !file.type) {
                    if (file.url) {
                        if (typeof file.url === 'string' || file.url instanceof String) {
                            if (file.url.length) {
                                return file.url
                            }
                        }
                    }
                    return ''
                }

                let icon = this.getFileIcon(file)
                if (icon) {
                    return icon
                }

                let imgExt = ['image/jpeg', 'image/png', 'image/svg+xml']
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
            }
        }
    }
</script>
<style lang="scss" scoped>
    .custom-file-label {
        height: 100px;
    }
    .custom-file-label::after {
        content: attr(data-label-text) !important;
        height: auto !important;
        justify-content: center;
        align-items: center;
        display: flex;
    }
    .custom-file {
        height: 100px !important;
    }
    .preview-image {
        position: relative;
        &-empty {
            padding-bottom: 60%;
        }
        &-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            border-bottom: 1px solid #f3f1f9;
            img {
                max-width: 100%;
                max-height: 100%;
            }
            .unselected-text {
                display: none;
                text-align: center;
            }
            &.unselected {
                background-color: #D8D8D8;
                .unselected-text {
                    display: block;
                    color: #BABABA;
                    font-weight: bold;
                }
            }
        }
    }
</style>

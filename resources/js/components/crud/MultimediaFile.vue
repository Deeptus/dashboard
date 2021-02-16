<template>
    <label class="multimedia-file mb-3" @click="selectFile()">
        <div class="multimedia-file__preview" :style="'background-image: url('+getPreviewImage()+');'"></div>
        <div class="multimedia-file__label">{{ input.label[lang()] }}</div>
        <div class="multimedia-file__text">{{ getText() }}</div>
        <!-- <input class="visually-hidden" type="file" @change="onFileChange($event)"> -->
    </label>
</template>
<script>

    export default {
        props: {
            input: {
                type: Object,
                default: {}
            },
            value: {
                type: Object,
                default: {}
            }
        },
        components: {},
        data(){
            return{
                displayImage: false,
                image: '',
            }
        },
        created() {
            this.image = this.value.value
        },
        mounted () {},
        watch: {
            image: function(val, oldVal) {
                console.log(this.image)
                this.value.value = this.image || []
            }
        },
        methods: {
            async selectFile() {
                await this.fileManager().open().then((callback) => {
                    if (callback) {
                        this.image.id   = callback.id
                        this.image.path = callback.path
                        this.image.type = callback.type
                        this.image.url  = callback.url
                    }
                })
            },
            lang() {
                return document.documentElement.lang
            },
            removeImage () {
                this.image      = {}
                this.image.url  = ''
                this.image.path = ''
                this.image.type = ''
                this.image.remove = true
            },
            onFileChange(e) {
                this.displayImage = false
                const file = e.target.files[0];
                this.image = file
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
                        icon: this.storagePath('/images/icons/zip.svg')
                    },
                    {
                        ext: [
                            'application/pdf'
                        ],
                        icon: this.storagePath('/images/icons/pdf.svg')
                    },
                    {
                        ext: [
                            'text/csv',
                            'text/xml',
                            'text/plain'
                        ],
                        icon: this.storagePath('/images/icons/txt.svg')
                    },
                    {
                        ext: [
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel'
                        ],
                        icon: this.storagePath('/images/icons/xls.svg')
                    },
                    {
                        ext: [
                            'application/msword'
                        ],
                        icon: this.storagePath('/images/icons/doc.svg')
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
                if (!this.image) {
                    return ''
                }
                let file = this.image
                if (!this.$root.checkValidFileSize(file)) {
                    return this.storagePath('/images/icons/Emblem-important-red.svg')
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

                let imgExt = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/svg']
                if (imgExt.includes(file.type)) {
                    if (file && file instanceof File) {
                        return URL.createObjectURL(file)
                    }
                    if (typeof file === 'object' || file instanceof Object) {
                        return file.url
                    }
                }
                return this.storagePath('/images/icons/raw.svg')
                if (typeof file === 'string' || file instanceof String) {
                    return this.storage_path(file)
                }
            },
            getText() {
                if (this.image && this.image instanceof File) {
                    return this.image.name
                }
                if (!this.image) {
                    return ''
                }
                return this.image.path.split('/').pop()
            },
            itemURL() {
                if (this.image && this.image instanceof File) {
                    return URL.createObjectURL(this.image)
                }
                if (typeof this.image === 'object' || this.image instanceof Object) {
                    return this.image.url
                }
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>
    .multimedia-file {
        height: 56px;
        border: 1px solid #cbc8d0;
        width: 100%;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        &__label {
            color: #444;
            opacity: 0.65;
            font-size: 13px;
            left: 95px;
            position: absolute;
            top: 7px;
        }
        &__preview {
            left: 0;
            top: 0;
            bottom: 0;
            width: 85px;
            border-right: 1px solid #cbc8d0;
            position: absolute;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        &__text {
            position: absolute;
            left: 94px;
            top: 25px;
        }
    }
</style>

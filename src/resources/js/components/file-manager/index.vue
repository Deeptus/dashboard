<template>
    <div class="file-manager" v-if="display == true">
        <div class="file-manager__overlay" @click="close()"></div>
        <div class="file-manager__modal">
            <div class="file-manager__header">
                <h3>Explorador de Archivos</h3>
                <div class="file-manager__close-btn" @click="close()">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="file-manager__tabs">
                <div class="file-manager__tab" :class="{'file-manager__tab--active': state == 'upload' }" @click="state = 'upload'">Subir archivos</div>
                <div class="file-manager__tab" :class="{'file-manager__tab--active': state == 'library' }" @click="state = 'library'">Biblioteca de medios</div>
            </div>
            <div class="file-manager__upload" v-if="state == 'upload'">
                <h3>Arrastra los archivos para subirlos</h3>
                <h3>o</h3>
                <label class="btn btn-primary btn-lg mb-2">
                    Seleccionar archivos
                    <input class="visually-hidden" type="file" @change="onFileChange($event)" multiple>
                </label>
                <p>Tamaño máximo de archivo: 2 MB.</p>
            </div>
            <div class="file-manager__files" v-if="state == 'library'">
                <div class="file-manager__file" @click="selected_id = file.id" :class="{ 'file-manager__file--selected': selected_id == file.id }" v-for="(file, key) in files" :key="key" :style="'background-image: url(' + file.url + ')'"></div>
            </div>
            <div class="file-manager__controls">
                <div class="btn btn-primary" @click="selected()"><i class="fas fa-check"></i> Seleccionar</div>
            </div>
            <div class="file-manager__overlay-upload" v-if="uploadingFiles == true">
                <h3>Subiendo Archivos</h3>
                <i class="fas fa-sync fa-spin"></i>
            </div>
        </div>
    </div>
</template>
<script>
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: [ 'urlData' ],
        data(){
            return{
                display: false,
                state: 'library',
                files: [],
                selected_id: 0,
                uploadingFiles: false,
                callback: null
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.files = response.data
                    this.loaded = 1
                });
            });
        },
        mounted () {},
        watch: {
            selected_id: function(val, oldVal) {}
        },
        methods: {
            open: function() {
                document.body.style.overflow = 'hidden'
                this.returnSelected = null
                this.selected_id = 0
                this.display = true
                return this.callback = new Promise((resolve, reject) => {
                    Object.defineProperty(this, "returnSelected", {
                        set: value => {
                            if (value) {
                                resolve(value)
                            }
                        }
                    })
                })
            },
            close() {
                document.body.style.overflow = 'auto'
                this.display = false
                this.selected_id = 0
                this.returnSelected = null
            },
            selected() {
                if (this.selected_id != 0) {
                    let fileSelected = this.files.find(file => {
                        return file.id == this.selected_id
                    })
                    if (fileSelected) {
                        /*
                        let fileSelectedObservable = {}
                        this.$set(fileSelectedObservable, 'id', fileSelected.id)
                        this.$set(fileSelectedObservable, 'path', fileSelected.path)
                        this.$set(fileSelectedObservable, 'type', fileSelected.type)
                        this.$set(fileSelectedObservable, 'url', fileSelected.url)
                        */
                        this.returnSelected = fileSelected
                    }
                }
                this.close()
            },
            onFileChange(e) {
                this.uploadingFiles = true
                let formData = new FormData()
                Array.prototype.forEach.call(e.target.files, (file, index) => {
                    if (file && file instanceof File) {
                        formData.append('items['+index+']', file)
                    }
                })
                axios.post(this.urlData, formData).then((response) => {
                    response.data.forEach(file => {
                        this.files.unshift(file)
                    });
                    this.uploadingFiles = false
                    this.state = 'library'
                    this.selected_id = this.files[0].id
                }).catch((error) => {
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
    .file-manager {
        position: fixed;
        z-index: 9;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        &__overlay {
            background-color: rgba(0, 0, 0, 0.3);
            position: absolute;
            width: 100%;
            height: 100%;
        }
        &__modal {
            position: relative;
            width: calc(100% - 60px);
            height: calc(100% - 60px);
            background-color: #FFF;
            padding: 15px;
            margin: 30px;
            display: flex;
            flex-direction: column;
        }
        &__overlay-upload {
            background-color: rgba(0, 0, 0, 0.3);
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;

            color: #FFF;
            text-shadow: 1px 1px 2px #000;
            user-select: none;
            h3 {
                padding-bottom: 3px;
                font-size: 32px;
                font-weight: 800;
            }
            i {
                font-size: 40px;
            }
        }
        &__close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 1.5em;
            opacity: .7;
            cursor: pointer;
            transition: all .1s ease;
            &:hover {
                opacity: 1;
            }
        }
        &__tabs {
            border-bottom: 1px solid #CCC;
            width: calc(100% + 30px);
            margin: 15px -15px 15px -15px;
            padding: 0 15px;
            display: flex;
        }
        &__tab {
            padding: 7.5px;
            cursor: pointer;
            border: 1px solid #FFF;
            border-bottom: 1px solid #CCC;
            margin-bottom: -1px;
            &--active {
                border: 1px solid #CCC;
                border-bottom: 1px solid #FFF;
            }
        }
        &__upload {
            flex-grow: 1;
            justify-content: center;
            display: flex;
            align-self: center;
            flex-direction: column;
            text-align: center;
        }
        &__files {
            flex-grow: inherit;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 15px;
            padding: 7.5px;
            margin-bottom: 15px;
        }
        &__file {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
            position: relative;
            &:hover {
                box-shadow: 0 0 2px 2px #0073aa;
            }
            &--selected {
                box-shadow: 0 0 4px 4px #0073aa !important;
                &::before {
                    font-family: "Font Awesome 5 Free";
                    font-weight: 900;
                    content: "";
                    color: #FFF;
                    font-size: 19px;
                    width: 30px;
                    height: 30px;
                    background-color: #0073aa;
                    position: absolute;
                    border: 1px solid #FFF;
                    box-shadow: 0 0 0 1px #0073aa;
                    right: -6px;
                    top: -6px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
            }
            &::after {
                content: "";
                padding-bottom: 100%;
                width: 100%;
                display: block;
            }
        }
        &__controls {
            display: flex;
            justify-content: flex-end;
            margin-top: auto;
        }
    }
</style>
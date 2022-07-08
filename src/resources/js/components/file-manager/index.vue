<template>
    <div :class="{ 'file-manager': insideModal == true }" v-if="( display == true && insideModal == true ) || insideModal == false">
        <div class="file-manager__overlay" @click="close()" v-if="insideModal == true"></div>
        <div class="file-manager__modal" @drop="drop($event)" @dragover="dragover($event)" @dragleave="dragleave($event)">
            <div class="file-manager__header">
                <h3>Explorador de Archivos</h3>
                <div class="file-manager__close-btn" @click="close()" v-if="insideModal == true">
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
            <template v-if="state == 'library'">
                <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 12px;">
                    <div class="form-floating mx-2" style="max-width: 400px; width: 100%;">
                        <select class="form-select" id="displayOnly" v-model="displayOnly" aria-label="Seleccione tipo de archivo">
                            <option value="all" :key="'all'">Todos</option>
                            <option :value="t" v-for="t in types" :key="t">{{ t }}</option>
                        </select>
                        <label for="displayOnly">Seleccione tipo de archivo</label>
                    </div>
                    <div class="form-floating mx-2" style="max-width: 400px; width: 100%;">
                        <input class="form-control" type="text" v-model="search" placeholder="Buscar...">
                        <label>Buscar...</label>
                    </div>
                </div>
                <div class="file-manager__files">
                    <template v-for="(file, key) in getFiles()">
                        <div
                            class="file-manager__file"
                            @click="selectFile(file)"
                            v-if="!excludeIds.includes(file.id) && (displayOnly=='all' || displayOnly==file.type)"
                            :class="{ 'file-manager__file--selected': selected_id == file.id }"
                            :key="key"
                        >
                            <div class="file-manager__img">
                                <img :src="getPreviewImage(file)" alt="">
                            </div>
                            <div class="file-manager__details" @click="details(file, $event)">Detalles</div>
                            <div class="file-manager__info">
                                <div class="file-manager__name">{{ file.original_name }}</div>
                                <div class="file-manager__type">{{ file.type }}</div>
                                <div class="file-manager__size">{{ sizeHumanReadable(file.size) }}</div>
                                <div class="file-manager__dimensions">Ancho: {{ file.width }}px - Alto: {{ file.height }}px</div>
                            </div>
                        </div>
                    </template>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" :class="{'disabled': records.current_page == 1}">
                            <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(1)">
                                &laquo; Primera
                            </a>
                        </li>
                        <li
                            class="page-item"
                            v-for="page in paginator"
                            :class="{'active': records.current_page == page}"
                            :key="page"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="changePage(page)"
                            >
                                {{ page }}
                            </a>
                        </li>
                        <li class="page-item" :class="{'disabled': records.current_page == records.last_page}">
                            <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(records.last_page)">
                                Última &raquo;
                            </a>
                        </li>
                    </ul>
                </nav>
            </template>
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 12px;" v-if="state == 'upload'">
                <div class="form-floating mx-2" style="max-width: 200px; width: 100%;">
                    <div class="form-control">{{ filesToSend.length }}</div>
                    <label>Total de archivos a Subir</label>
                </div>
                <div class="form-floating mx-2" style="max-width: 300px; width: 100%;">
                    <select class="form-select" id="uploadMode" v-model="uploadMode" aria-label="Modo de subida">
                        <option value="normal" :key="'normal'">Normal</option>
                        <option value="replace-same-name" :key="'replace-same-name'">Remplazar Archivos con el mismo nombre</option>
                    </select>
                    <label for="uploadMode">Modo de subida</label>
                </div>
            </div>
            <div class="file-manager__files" v-if="state == 'upload'">
                <template v-for="(file, key) in filesToSend">
                    <div class="file-manager__file" :key="'up'+key">
                        <div class="file-manager__img">
                            <img :src="getPreviewImage(file)" alt="" v-if="filesToSend.length < 50">
                        </div>
                        <div class="file-manager__remove" @click="remove(key)" v-if="file.meta.state == 'pending'"><i class="fas fa-times"></i></div>
                        <div class="file-manager__details" @click="details(file, $event)">Detalles</div>
                        <div class="file-manager__state file-manager__state--uploading" v-if="file.meta.state == 'uploading'">
                            <div class="file-manager__state-icon">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <div class="file-manager__state-text">Subiendo</div>
                        </div>
                        <div class="file-manager__state file-manager__state--error" v-if="file.meta.state == 'error'">
                            <div class="file-manager__state-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="file-manager__state-text">Error</div>
                        </div>
                        <div class="file-manager__state file-manager__state--success" v-if="file.meta.state == 'success-new'">
                            <div class="file-manager__state-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="file-manager__state-text">Subido</div>
                        </div>
                        <div class="file-manager__state file-manager__state--success" v-if="file.meta.state == 'success-replace'">
                            <div class="file-manager__state-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="file-manager__state-text">Remplazado</div>
                        </div>
                        <div class="file-manager__state file-manager__state--pending" v-if="file.meta.state == 'pending'">
                            <div class="file-manager__state-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="file-manager__state-text">Pendiente</div>
                        </div>
                        <div class="file-manager__info">
                            <div class="file-manager__name">{{ file.name }}</div>
                            <div class="file-manager__type">{{ file.type }}</div>
                            <div class="file-manager__size">{{ sizeHumanReadable(file.size) }}</div>
                            <div class="file-manager__dimensions">Ancho: {{ file.meta.width }}px - Alto: {{ file.meta.height }}px</div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="file-manager__controls">
                <div class="btn btn-default me-auto" @click="returnNone()"><i class="fas fa-check"></i> No seleccionar nada</div>
                <div class="btn btn-primary" @click="selected()" v-if="insideModal == true && state == 'library'"><i class="fas fa-check"></i> Seleccionar</div>
                <div class="btn btn-primary" @click="sendFiles()" v-if="state == 'upload'"><i class="far fa-paper-plane"></i> Enviar</div>
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
    import Details from './details.vue';
    export default {
        props: {
            urlData: {
                type: String,
                default: '',
            },
            insideModal: {
                type: Boolean,
                default: true,
            },
        },
        data(){
            return{
                display: false,
                state: 'library',
                displayOnly: 'all',
                types: [],
                files: [],
                selected_id: 0,
                uploadingFiles: false,
                callback: null,
                excludeIds: [],
                filesToSend: [],
                search: '',
                uploadMode: 'normal',
                records: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 21,
                    total: 0,
                }
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.files = response.data
                    this.types = [...new Set(this.files.map(item => item.type))]
                    this.loaded = 1
                });
            });
        },
        mounted () {},
        watch: {
            selected_id: function(val, oldVal) {}
        },
        methods: {
            open: function(property = {}) {
                document.body.style.overflow = 'hidden'
                this.returnSelected = null
                this.selected_id = 0
                this.display = true
                if (property.excludeIds) {
                    this.excludeIds = property.excludeIds
                }
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
            details(file, event) {
                event.stopPropagation()
                am().openModal(Details,{ file, endpoint: this.urlData })
            },
            remove(key) {
                this.filesToSend.splice(key, 1)
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
                        icon: this.publicPath('/images/icons/zip.svg')
                    },
                    {
                        ext: [
                            'application/pdf'
                        ],
                        icon: this.publicPath('/images/icons/pdf.svg')
                    },
                    {
                        ext: [
                            'text/csv',
                            'text/xml',
                            'text/plain'
                        ],
                        icon: this.publicPath('/images/icons/txt.svg')
                    },
                    {
                        ext: [
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel'
                        ],
                        icon: this.publicPath('/images/icons/xls.svg')
                    },
                    {
                        ext: [
                            'application/msword'
                        ],
                        icon: this.publicPath('/images/icons/doc.svg')
                    },
                ]
                fileIcon.forEach(item => {
                    if (item.ext.includes(file.type)) {
                        icon = item.icon
                    }
                });
                return icon
            },
            getPreviewImage(file) {
                // file.url
                let imgExt = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/svg', 'image/webp', 'image/gif', 'image/bmp']
                if (file && file instanceof File && imgExt.includes(file.type)) {
                    return URL.createObjectURL(file)
                }
                if (imgExt.includes(file.type)) {
                    return file.url
                }
                return this.getFileIcon(file)
                
                return this.publicPath('/images/icons/raw.svg')
                if (typeof file === 'string' || file instanceof String) {
                    return this.storage_path(file)
                }
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
            returnNone() {
                this.returnSelected = {}
                this.close()
            },
            onFileChange(e) {
                this.selectFiles(e.target.files)
            },
            sendFiles() {
                let promise = Promise.resolve()
                this.filesToSend.forEach(file => {
                    if (file.meta.state == 'pending') {
                        file.meta.state = 'uploading'
                        this.$forceUpdate()
                        promise = promise.then(() => {
                            return new Promise((resolve, reject) => {
                                setTimeout(() => {
                                    let formData = new FormData()
                                    formData.append('items[0]', file)
                                    formData.append('upload_mode', this.uploadMode)
                                    axios.post(this.urlData, formData).then((response) => {
                                        response.data.forEach(f => {
                                            this.files.unshift(f)
                                            file.meta.state = f.message
                                        })
                                        this.$forceUpdate()
                                        resolve()
                                    }).catch((error) => {
                                        file.meta.state = 'error'
                                        this.$forceUpdate()
                                        resolve()
                                    })
                                }, 500)
                            })
                        })
                    }
                })
                // this.uploadingFiles = true
                // let formData = new FormData()
                // Array.prototype.forEach.call(e.target.files, (file, index) => {
                //     if (file && file instanceof File) {
                //         formData.append('items['+index+']', file)
                //     }
                // })
                // axios.post(this.urlData, formData).then((response) => {
                //     response.data.forEach(file => {
                //         this.files.unshift(file)
                //     });
                //     this.uploadingFiles = false
                //     this.state = 'library'
                //     this.selected_id = this.files[0].id
                // }).catch((error) => {
                // })
            },
            sizeHumanReadable(size) {
                let units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
                try {
                    let i = 0
                    while (size >= 1024) {
                        size /= 1024
                        ++i
                    }
                    // console.log(size)
                    return size.toFixed(1) + ' ' + units[i]
                } catch (error) {
                    console.log(size, units, error)
                }
            },
            changePage(page) {
                this.records.current_page = page
            },
            getFiles() {
                // filter files by search
                let files = this.files.filter(file => {
                    if (this.search && file.original_name) {
                        return file.original_name.toLowerCase().includes(this.search.toLowerCase())
                    }
                    if (this.search && file.path) {
                        return file.path.toLowerCase().includes(this.search.toLowerCase())
                    }
                    return true
                })
                // paginate
                let records = []
                let page = this.records.current_page
                let perPage = this.records.per_page
                let start = (page - 1) * perPage
                let end = page * perPage
                for (let i = start; i < end; i++) {
                    if (files[i]) {
                        records.push(files[i])
                    }
                }
                this.records.total = files.length
                this.records.last_page = Math.ceil(files.length / perPage)
                return records
            },
            drop(e) {
                e.preventDefault()
                e.stopPropagation()
                let dt = e.dataTransfer
                let files = dt.files
                this.selectFiles(files)
            },
            selectFiles(files) {
                Array.from(files).forEach(file => {
                    this.$set(file, 'meta', {})
                    this.$set(file.meta, 'state', 'pending')
                    this.$set(file.meta, 'width', 0)
                    this.$set(file.meta, 'height', 0)
                    const img = new Image()
                    img.onload = () => {
                        file.meta.width = img.width
                        file.meta.height = img.height
                        this.$forceUpdate()
                    }
                    img.src = URL.createObjectURL(file)
                    this.filesToSend.push(file)
                    window.filesToSend = this.filesToSend
                    this.state = 'upload'
                })
            },
            dragover(e) {
                e.preventDefault()
                e.stopPropagation()
            },
            dragleave(e) {
                e.preventDefault()
                e.stopPropagation()
            },
            selectFile(file) {
                if ( this.insideModal ) {
                    this.selected_id = file.id
                }
            },
        },
        computed: {
            paginator() {
                let pages = []
                let maxPages = 14
                let page = this.records.current_page
                let lastPage = this.records.last_page
                let start = page - maxPages / 2
                let end = page + maxPages / 2
                if (end > lastPage) {
                    end = lastPage
                    start = lastPage - maxPages + 1
                }
                if (start < 1) {
                    start = 1
                    // end = maxPages
                }
                for (let i = start; i <= end; i++) {
                    pages.push(i)
                }
                // console.log(pages)
                return pages
            },
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
        &__header {
            margin: -15px -15px 0 -15px;
            padding: 15px;
            background-color: #e7e7e7;
        }
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
            border: 1px solid #CCC;
            @media (max-width: 768px) {
                margin: 0;
                width: 100%;
                height: 100%;
            }
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
            margin: 0 -15px 15px -15px;
            padding: 15px 15px 0;
            display: flex;
            background-color: #e7e7e7;
        }
        &__tab {
            padding: 7.5px;
            cursor: pointer;
            border: 1px solid #FFF;
            border-bottom: 1px solid #CCC;
            margin-bottom: -1px;
            background-color: #efefef;
            &--active {
                border: 1px solid #CCC;
                border-bottom: 1px solid #FFF;
                background-color: #FFF;
                box-shadow: -3px -3px 4px #d9d9d9;
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
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 15px;
            padding: 7.5px;
            margin-bottom: 15px;
            @media (max-width: 1200px) {
                grid-template-columns: repeat(6, 1fr);
            }
            @media (max-width: 992px) {
                grid-template-columns: repeat(5, 1fr);
            }
            @media (max-width: 768px) {
                grid-template-columns: repeat(4, 1fr);
            }
            @media (max-width: 576px) {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        &__info {
            position: absolute;
            overflow: hidden;
            top: 38px;
            left: 0;
            right: 0;
            white-space: nowrap;
            background-color: rgba(255, 255, 255, .7);
            padding: 3px 5px;
            font-size: 12px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            opacity: .4;
            transition: all .1s ease;
        }
        &__file {
            background: linear-gradient(-45deg, #4d4d4d, #838383, #b8b8b8, #ffffff);
            background-size: 500% 500%;
            animation: file-manager__file_gradient 5s ease infinite;
            cursor: pointer;
            position: relative;
            &:hover {
                box-shadow: 0 0 2px 2px #0073aa;
                .file-manager__info {
                    opacity: 1;
                }
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
        &__state {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            font-size: 11px;
            padding: 4px;
            background-color: #f3ffb3;
            color: #3c3c3c;
            letter-spacing: 0.5px;
            &-icon {
                margin-right: 3px;
            }
            &--uploading {
                background-color: #fda769;
                color: #3c3c3c;
            }
            &--error {
                background-color: #fd0505;
                color: #FFF;
            }
            &--success {
                background-color: #009900;
                color: #FFF;
            }
            &--pending {
                background-color: #f3ffb3;
                color: #3c3c3c;
            }
        }
        &__img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            img {
                max-width: calc(100% - 15px);
                max-height: calc(100% - 15px);
            }
        }
        &__details {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 5px 15px;
            background-color: #0073aa;
            color: #FFF;
            &:hover {
                background-color: #214150;
            }
        }
        &__remove {
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px 15px;
            background-color: #aa0000;
            color: #FFF;
            &:hover {
                background-color: #520000;
            }
        }
        &__controls {
            display: flex;
            justify-content: flex-end;
            margin-top: auto;
        }
    }
    @keyframes file-manager__file_gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
</style>
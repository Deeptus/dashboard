<template>
    <div class="row">
        <div class="col-md-12">
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
        </div>
        <div class="col-md-12" v-if="loaded == 1">
            <div class="card">
                <div class="card-header">
                    Crud: {{ table.tablename }}
                </div>
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="form-floating flex-grow-1">
                                    <input type="text" class="form-control" v-model="table.tablename">
                                    <label for="floatingInput">Table name</label>
                                </div>
                                <button class="btn btn-outline-secondary" type="button" @click="table.tablename = slugify(table.tablename, '_')"><i class="fas fa-hand-scissors"></i> Slug</button>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md" v-for="langkey in Object.keys(languages)" :key="'Name' + langkey">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" v-model="table.name[langkey]">
                                        <label for="floatingInput">Name: {{ languages[langkey] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="id" v-model="table.id">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="id">ID</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="order_index" v-model="table.order_index">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="order_index">Order Index</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="uuid" v-model="table.uuid">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="uuid">UUID</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="timestamps" v-model="table.timestamps">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="timestamps">TIMESTAMPS</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="softDeletes" v-model="table.softDeletes">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="softDeletes">softDeletes</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="slug" v-model="table.slug">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="slug">SLUG</label>
                                    </div>
                                </div>
                                <div class="col-md" v-if="table.slug == 1">
                                    <div class="form-floating">
                                        <select class="form-select" id="slug_global" v-model="table.slug_global">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="slug_global">SLUG GLOBAL</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="is_authenticatable" v-model="table.is_authenticatable">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="is_authenticatable">Is Authenticatable</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <fieldset class="mt-3">
                <legend>Inputs:</legend>
                <div class="card mt-3" v-for="( input, inputKey ) in inputs" :key="inputKey">
                    <div class="card-header">
                        Input {{ input.columnname }}
                        <div class="card-header-btns">
                            <div class="btn btn-warning" @click="inputUp(inputKey)" v-if="inputKey > 0"><i class="fas fa-angle-up"></i></div>
                            <div class="btn btn-warning" @click="inputDown(inputKey)" v-if="inputKey < ( inputs.length - 1 ) && inputs.length > 1"><i class="fas fa-angle-down"></i></div>
                            <div class="btn btn-danger"  @click="rmInput(inputKey)"><i class="fas fa-trash"></i></div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="form-floating flex-grow-1">
                                        <input type="text" class="form-control" v-model="input.columnname">
                                        <label for="floatingInput">Column name</label>
                                    </div>
                                    <button class="btn btn-outline-secondary" type="button" @click="input.columnname = slugify(input.columnname, '_')"><i class="fas fa-hand-scissors"></i> Slug</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" v-model="input.type">
                                        <optgroup label="Text">
                                            <option value="text">text</option>
                                            <option value="textarea">textarea</option>
                                            <option value="wysiwyg">WYSIWYG</option>
                                            <option value="email">email</option>
                                            <option value="url">url</option>
                                            <option value="tel">tel</option>
                                        </optgroup>
                                        <optgroup label="Numeric">
                                            <option value="number">number</option>
                                            <option value="bigInteger">bigInteger</option>
                                            <option value="money">money</option>
                                            <option value="password">password</option>
                                        </optgroup>
                                        <optgroup label="Datetime">
                                            <option value="date">date</option>
                                            <option value="time">time</option>
                                            <option value="datetime">datetime</option>
                                            <option value="week">week</option>
                                        </optgroup>
                                        <optgroup label="File">
                                            <option value="multimedia_file">Multimedia File</option>
                                            <option value="gallery">Gallery</option>
                                        </optgroup>
                                        <optgroup label="Select's">
                                            <option value="true_or_false">BOOLEAN (True or False)</option>
                                            <option value="select">select</option>
                                            <option value="radio">radio</option>
                                            <option value="checkbox">checkbox</option>
                                            <option value="select2">select2</option>
                                            <option value="select2multiple">select2multiple</option>
                                            <option value="subForm">subForm</option>
                                        </optgroup>
                                        <optgroup label="Special">
                                            <option value="card-header">CARD Header</option>
                                            <option value="map-select-lat-lng">Map selector Lat-Lon</option>
                                        </optgroup>
                                    </select>
                                    <label>TYPE</label>
                                </div>
                            </div>
                            <div class="col-md-12" v-if="inputParams(input).includes('label')">
                                <div class="row">
                                    <div class="col-md" v-for="langkey in Object.keys(languages)" :key="'Label' + langkey">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" v-model="input.label[langkey]">
                                            <label for="floatingInput">Label: {{ languages[langkey] }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="col-md" v-if="inputParams(input).includes('listable')">
                                        <div class="form-floating">
                                            <select class="form-select" v-model="input.listable">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <label>LISTABLE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('validate')">
                                        <div class="form-floating">
                                            <select class="form-select" v-model="input.validate">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <label>VALIDATE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('unique')">
                                        <div class="form-floating">
                                            <select class="form-select" v-model="input.unique">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <label>UNIQUE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('gridcols')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.gridcols">
                                            <label for="floatingInput">GRID COLS</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('default')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.default">
                                            <label for="floatingInput">DEFAULT VALUE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('nullable')">
                                        <div class="form-floating">
                                            <select class="form-select" v-model="input.nullable">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <label>NULLABLE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('max')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.max">
                                            <label for="floatingInput">MAX</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('min')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.min">
                                            <label for="floatingInput">MIN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector')">
                                        <div class="form-floating">
                                            <select class="form-select" v-model="input.valueoriginselector">
                                                <option value="table">Table</option>
                                                <option value="values">Values</option>
                                            </select>
                                            <label>VALUES ORIGIN</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-if="inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'values'">
                                        <div v-if="Array.isArray(input.options)">
                                            <div class="row" v-for="(option, optionKey) in input.options" :key="input.columnname + optionKey">
                                                <div class="col-4 pr-0">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" v-model="option.key">
                                                        <label for="floatingInput">KEY</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 p-0">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" v-model="option.text">
                                                        <label for="floatingInput">TEXT</label>
                                                    </div>
                                                </div>
                                                <div class="col-2 pl-0 d-flex">
                                                    <button type="button" @click="removeOption(input, optionKey)" class="btn btn-secondary">
                                                        <i class="fas fa-trash fa-sm text-white-50"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-sm-flex align-items-center justify-content-center mt-3">
                                            <button type="button" @click="addOption(input)" class="btn btn-secondary">
                                                <i class="fas fa-plus fa-sm text-white-50"></i>
                                                Add Option
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="(inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table') || inputParams(input).includes('tabledata')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.tabledata">
                                            <label for="floatingInput">TABLE DATA</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="(inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table') || inputParams(input).includes('tablekeycolumn')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.tablekeycolumn">
                                            <label for="floatingInput">TABLE KEY COlUMN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table'">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.tabletextcolumn">
                                            <label for="floatingInput">TABLE TEXT COlUMN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('referencecolumn')">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" v-model="input.referencecolumn">
                                            <label for="floatingInput">REFERENCE COLUMN</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-center mt-3">
                    <button type="button" @click="addInput()" class="btn btn-secondary">
                        <i class="fas fa-plus fa-sm text-white-50"></i>
                        Add Input
                    </button>
                </div>
            </fieldset>
            <div class="d-sm-flex align-items-center justify-content-between mt-4">
                <a :href="urlBack" class="btn btn-sm btn-warning">
                    <i class="fas fa-step-backward fa-sm text-white-50"></i>
                    Volver Atras
                </a>

                <button type="button" @click="sendForm()" class="btn btn-lg btn-primary">
                    <i class="fas fa-save fa-sm text-white-50"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    import Swal from 'sweetalert2'
    
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            formName: {
                type: String,
                default: 'Form'
            },
            urlData: {
                type: String,
                default: ''
            },
            urlBack: {
                type: String,
                default: ''
            },
            urlAction: {
                type: String,
                default: ''
            }
        },
        components: {},
        data(){
            return{
                languages: {},
                table: {
                    id: 1,
                    uuid: 0,
                    order_index: 0,
                    tablename: '',
                    name: {},
                    timestamps: 1,
                    softDeletes: 1,
                    slug: 0,
                    slug_global: 0,
                    is_authenticatable: 0
                },
                inputs: [],
                loaded: 0
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.languages = response.data.languages
                    if(response.data.content) {
                        this.table  = response.data.content.table
                        this.inputs = response.data.content.inputs
                    }
                    this.loaded = 1
                });
            });
        },
        mounted () {},
        watch: {},
        methods: {
            addOption(input) {
                if (!Array.isArray(input.options)) {
                    this.$set(input, 'options', [])
                    // input.options = Vue.observable([])
                }
                input.options.push({
                    key: '',
                    text: ''
                })
            },
            removeOption(input, key) {
                input.options.splice(key,1)
            },
            languagesKeys() {
                this.languages.keys
            },
            addInput() {
                this.inputs.push({
                    columnname: '',
                    type: 'text',
                    label: {},
                    unique: 0,
                    default: '',
                    nullable: 0,
                    validate: 1,
                    max: '',
                    min: '',
                    tabledata: '',
                    tablekeycolumn: '',
                    tabletextcolumn: '',
                })
            },
            inputParams(input) {
                let params = []
                if (input.type == 'text') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'card-header') {
                }
                if (input.type == 'textarea') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'wysiwyg') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'email') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'url') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'tel') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'number') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'bigInteger') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'money') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'password') {
                    params.push('listable', 'validate', 'label', 'unique', 'default', 'gridcols', 'nullable', 'max', 'min')
                }
                if (input.type == 'true_or_false') {
                    params.push('label', 'default', 'gridcols')
                }

                if (input.type == 'multimedia_file') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'gallery') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'map-select-lat-lng') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }

                if (input.type == 'date') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'time') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'datetime') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'week') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'select') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'valueoriginselector')
                }
                if (input.type == 'radio') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'valueoriginselector')
                }
                if (input.type == 'checkbox') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'valueoriginselector')
                }
                if (input.type == 'select2') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'valueoriginselector')
                }
                if (input.type == 'select2multiple') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'valueoriginselector')
                }
                if (input.type == 'subForm') {
                    params.push('listable', 'validate', 'label', 'default', 'gridcols', 'nullable', 'tabledata', 'tablekeycolumn')
                }
                return params;
            },
            rmInput(key) {
                Swal.fire({
                    title: 'Eliminar',
                    icon: 'warning',
                    // width: 600,
                    html: '<div style="text-align: center;">'+'¿Esta seguro de eliminar?'+'</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Rechazar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.inputs.splice(key,1)
                    }
                })
            },
            inputUp(key) {
                this.inputs.splice(key - 1,0,this.inputs.splice(key,1)[0]);
            },
            inputDown(key) {
                this.inputs.splice(key + 1,0,this.inputs.splice(key,1)[0]);
            },
            sendForm() {
                Swal.fire({
                    title: 'Enviar',
                    icon: 'question',
                    // width: 600,
                    html: '<div style="text-align: center;">'+'¿Esta seguro de enviar el formulario?'+'</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Rechazar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.postForm()
                    }
                })
            },
            postForm() {
                let formData = new FormData()

                formData.append('data', JSON.stringify({
                    table: this.table,
                    inputs: this.inputs
                }));

                axios.post(this.urlAction, formData).then((response) => {
                    this.loaded = 3
                    setTimeout(() => {
                        this.loaded = 1
                        // window.location.href = response.data.redirect
                    }, 1000);
                }).catch((error) => {
                    if (error.response.data.message == 'CSRF token mismatch.') {
                        csrf.refresh()
                        .then(() => {
                            this.enviarPresupuesto()
                        })
                        .catch((err) => {
                            if (err.message == 'Unauthenticated.') {
                                this.openLoginFormModal()
                            }
                        });
                        return true
                    }
                    if (error.response.data.message == 'Unauthenticated.') {
                        this.openLoginFormModal()
                        return true
                    }
                    console.log(error.response.data)
                    this.loaded = 1
                })
            }
        },
        computed: {
        }
    }
</script>
<style lang="scss" scoped>
    .card-header {
        position: relative;
    }
    .card-header-btns {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
    }
</style>

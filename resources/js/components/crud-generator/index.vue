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
        <div class="p-col-md-12" v-if="loaded == 1">
            <div class="card">
                <h5>
                    Crud: {{ table.tablename }}
                </h5>
                <div class="card-body pb-0">
                    <div class="p-field p-grid">
                        <div class="p-col-12 p-mb-5">
                            <span class="p-float-label">

    <Dropdown v-model="table.icon" :options="icons" :filter="true" optionLabel="icon" optionValue="icon" dataKey="icon" placeholder="Icon for adm menu" >

    <template #value="slotProps">
        <div class="country-item country-item-value" v-if="slotProps.value">
            <i :class="slotProps.value" /> {{ slotProps.value }}

        </div>
        <span v-else>
            
        </span>
    </template>
    <template #option="slotProps">

            <i :class="slotProps.option.icon" /> {{ slotProps.option.icon }}

    </template>

                                </Dropdown>
                            </span>
                        </div>
                        <div class="p-col">
                            <div class="p-float-label">
                                <InputText type="text" class="" v-model="table.tablename"/>
                                <label for="">Table name</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <div class="p-col p-mb-5" v-for="langkey in Object.keys(languages)" :key="'Name' + langkey">
                                    <div class="p-float-label">
                                        <InputText type="text" class="" v-model="table.name[langkey]"/>
                                        <label for="floatingInput">Name: {{ languages[langkey] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-col-12">
                            <div class="p-formgroup-inline">

                                <div class="p-field-checkbox">
                                    
                                    <Checkbox v-model="table.id" :binary="true" />
                                    <label for="binary"> ID </label>
                                </div>
                                <div class="p-field-checkbox">
                                    <Checkbox v-model="table.uuid" :binary="true" />
                                    <label for="binary"> UUID </label>

                                </div>
                                <div class="p-field-checkbox">
                                    <Checkbox v-model="table.timestamps" :binary="true" />
                                    <label for="binary"> TIMESTAMPS </label>

                                </div>
                                <div class="p-field-checkbox">
                                    <Checkbox v-model="table.softDeletes" :binary="true" />
                                    <label for="binary"> SOFTDELETES </label>

                                </div>
                                <div class="p-field-checkbox">
                                    <Checkbox v-model="table.slug" :binary="true" />
                                    <label for="binary"> SLUG </label>

                                </div>
                                <div class="p-field-checkbox">
                                    <Checkbox v-model="table.menu_show" :binary="true" />
                                    <label for="binary"> MENU </label>

                                </div>


                                <div class="p-field p-col" v-if="table.slug == 1">
                                    <div class="p-float-label">
                                        <select class="form-select" id="slug_global" v-model="table.slug_global">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="slug_global">SLUG GLOBAL</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Fieldset class="p-fluid">
                <legend>Campos / Inputs :</legend>
                <div class="card mt-3" v-for="( input, inputKey ) in inputs" :key="inputKey">
                    <div class="card-header">

                        <div class="card-header-btns">
    <Button icon="pi pi-arrow-up" class="p-button-rounded p-button-secondary p-button-outlined" @click="inputUp(inputKey)" v-if="inputKey > 0"></Button>
    <Button icon="pi pi-arrow-down" class="p-button-rounded p-button-secondary p-button-outlined" @click="inputDown(inputKey)" v-if="inputKey < ( inputs.length - 1 ) && inputs.length > 1"></Button>
                            <Button class="p-button-rounded p-button-danger p-button-outlined" icon="pi pi-times" @click="rmInput(inputKey)"></Button>
                        </div>
                    </div>
                    <div class="">
                        <div class="p-fluid p-formgrid p-grid">
                            <div class="p-field p-col-6 p-mt-3 p-mb-3">
                                <div class="p-float-label">
                                    <InputText type="text" class="" v-model="input.columnname"/>
                                    <label for="floatingInput">Column name</label>
                                </div>
                            </div>
                            <div class="p-field p-col-6 p-mb-3 p-mt-3">
                                <div class="p-float-label">
                                    <select class="form-select" v-model="input.type">
                                        <option value="text">text</option>
                                        <option value="textarea">textarea</option>
                                        <option value="file">file</option>
                                        <option value="email">email</option>
                                        <option value="url">url</option>
                                        <option value="tel">tel</option>
                                        <option value="number">number</option>
                                        <option value="money">money</option>
                                        <option value="password">password</option>
                                        <option value="date">date</option>
                                        <option value="time">time</option>
                                        <option value="datetime">datetime</option>
                                        <option value="week">week</option>
                                        <option value="password">password</option>
                                        <option value="true_or_false">BOOLEAN (True or False)</option>
                                        <!-- -->
                                        <option value="select">select</option>
                                        <option value="radio">radio</option>
                                        <option value="checkbox">checkbox</option>
                                        <option value="select2">select2</option>
                                        <option value="select2multiple">select2multiple</option>
                                        
                                    </select>

                                </div>
                            </div>
                            <div class="p-col-4">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.gridcols"/>
                                            <label for="floatingInput">GRID COLS</label>
                                        </div>
                            </div>
                            <div class="p-field p-col-12" v-if="inputParams(input).includes('label')">
                                <div class="row">
                                    <div class="p-field p-col-4" v-for="langkey in Object.keys(languages)" :key="'Label' + langkey">
                                        <div class="p-float-label mb-3">
                                            <InputText type="text" class="" v-model="input.label[langkey]"/>
                                            <label for="floatingInput">Label: {{ languages[langkey] }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="p-formgroup-inline">
                                    <div class="p-col-3" >
                                        <div class="p-field-checkbox">
                                            <label for="binary">VISIBLE AL LISTAR</label>
                                            <Checkbox v-model="input.visible" :binary="true" />
                                        </div>
                                    </div>
                                    <div class="p-col-3" >
                                        <div class="p-field-checkbox">
                                            <label for="binary">VISIBLE  AL EDITAR / CREAR</label>
                                            <Checkbox v-model="input.visible_edit" :binary="true" />
                                        </div>
                                    </div>
                                    <div class="p-col-2" >
                                        <div class="p-field-checkbox">
                                            <label for="binary">VALIDATE</label>
                                            <Checkbox v-model="input.validate" :binary="true" />
                                        </div>
                                    </div>
                                    <div class="p-col-2" >
                                        <div class="p-field-checkbox">
                                            <label for="binary">UNIQUE</label>
                                            <Checkbox v-model="input.unique" :binary="true" />
                                        </div>
                                    </div>



                                    <div class="p-col-2" v-if="inputParams(input).includes('translatable')">
                                        <div class="p-field-checkbox">
                                            <label for="binary">TRANSLATABLE</label>
                                            <Checkbox v-model="input.translatable" :binary="true" />
                                        </div>
                                    </div>

                                    <div class="col-md" v-if="inputParams(input).includes('default')">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.default"/>
                                            <label for="floatingInput">DEFAULT VALUE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('nullable')">
                                        <div class="p-float-label">
                                            <select class="form-select" v-model="input.nullable">
                                                <option value="0">No</option>
                                                <option value="1" selected="">Yes</option>
                                            </select>
                                            <label>NULLABLE</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('max')">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.max"/>
                                            <label for="floatingInput">MAX</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('min')">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.min"/>
                                            <label for="floatingInput">MIN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector')">
                                        <div class="p-float-label">
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
                                                    <div class="p-float-label">
                                                        <InputText type="text" class="" v-model="option.key"/>
                                                        <label for="floatingInput">KEY</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 p-0">
                                                    <div class="p-float-label">
                                                        <InputText type="text" class="" v-model="option.text"/>
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
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table'">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.tabledata"/>
                                            <label for="floatingInput">TABLE DATA</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table'">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.tablekeycolumn"/>
                                            <label for="floatingInput">TABLE KEY COlUMN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('valueoriginselector') && input.valueoriginselector == 'table'">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.tabletextcolumn"/>
                                            <label for="floatingInput">TABLE TEXT COlUMN</label>
                                        </div>
                                    </div>
                                    <div class="col-md" v-if="inputParams(input).includes('referencecolumn')">
                                        <div class="p-float-label">
                                            <InputText type="text" class="" v-model="input.referencecolumn"/>
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
                <Button type="button" @click="sendForm()" class="btn btn-lg btn-primary" label="GUARDAR" icon="pi pi-save">
                </Button>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import EventBus from './../../service/event-bus';
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
                    tablename: '',
                    name: {},
                    timestamps: 1,
                    softDeletes: 1,
                    menu_show: 1,
                    slug: 0,
                    slug_global: 0
                },
                inputs: [],
                loaded: 0,
                icons: [
                        { icon: 'pi pi-align-center' },
                        { icon: 'pi pi-align-justify' },
                        { icon: 'pi pi-align-left' },
                        { icon: 'pi pi-align-right' },
                        { icon: 'pi pi-android' },
                        { icon: 'pi pi-angle-double-down' },
                        { icon: 'pi pi-angle-double-left' },
                        { icon: 'pi pi-angle-double-right' },
                        { icon: 'pi pi-angle-double-up' },
                        { icon: 'pi pi-angle-down' },
                        { icon: 'pi pi-angle-left' },
                        { icon: 'pi pi-angle-right' },
                        { icon: 'pi pi-angle-up' },
                        { icon: 'pi pi-apple' },
                        { icon: 'pi pi-arrow-circle-down' },
                        { icon: 'pi pi-arrow-circle-left' },
                        { icon: 'pi pi-arrow-circle-right' },
                        { icon: 'pi pi-arrow-circle-up' },
                        { icon: 'pi pi-arrow-down' },
                        { icon: 'pi pi-arrow-left' },
                        { icon: 'pi pi-arrow-right' },
                        { icon: 'pi pi-arrow-up' },
                        { icon: 'pi pi-backward' },
                        { icon: 'pi pi-ban' },
                        { icon: 'pi pi-bars' },
                        { icon: 'pi pi-bell' },
                        { icon: 'pi pi-bookmark' },
                        { icon: 'pi pi-briefcase' },
                        { icon: 'pi pi-calendar' },
                        { icon: 'pi pi-calendar-minus' },
                        { icon: 'pi pi-calendar-plus' },
                        { icon: 'pi pi-calendar-times' },
                        { icon: 'pi pi-camera' },
                        { icon: 'pi pi-caret-down' },
                        { icon: 'pi pi-caret-left' },
                        { icon: 'pi pi-caret-right' },
                        { icon: 'pi pi-caret-up' },
                        { icon: 'pi pi-chart-bar' },
                        { icon: 'pi pi-chart-line' },
                        { icon: 'pi pi-check' },
                        { icon: 'pi pi-check-circle' },
                        { icon: 'pi pi-check-square' },
                        { icon: 'pi pi-chevron-circle-down' },
                        { icon: 'pi pi-chevron-circle-left' },
                        { icon: 'pi pi-chevron-circle-right' },
                        { icon: 'pi pi-chevron-circle-up' },
                        { icon: 'pi pi-chevron-down' },
                        { icon: 'pi pi-chevron-left' },
                        { icon: 'pi pi-chevron-right' },
                        { icon: 'pi pi-chevron-up' },
                        { icon: 'pi pi-circle-off' },
                        { icon: 'pi pi-circle-on' },
                        { icon: 'pi pi-clock' },
                        { icon: 'pi pi-clone' },
                        { icon: 'pi pi-cloud' },
                        { icon: 'pi pi-cloud-download' },
                        { icon: 'pi pi-cloud-upload' },
                        { icon: 'pi pi-cog' },
                        { icon: 'pi pi-comment' },
                        { icon: 'pi pi-comments' },
                        { icon: 'pi pi-compass' },
                        { icon: 'pi pi-copy' },
                        { icon: 'pi pi-desktop' },
                        { icon: 'pi pi-directions' },
                        { icon: 'pi pi-directions-alt' },
                        { icon: 'pi pi-dollar' },
                        { icon: 'pi pi-download' },
                        { icon: 'pi pi-eject' },
                        { icon: 'pi pi-ellipsis-h' },
                        { icon: 'pi pi-ellipsis-v' },
                        { icon: 'pi pi-envelope' },
                        { icon: 'pi pi-exclamation-circle' },
                        { icon: 'pi pi-exclamation-triangle' },
                        { icon: 'pi pi-external-link' },
                        { icon: 'pi pi-eye' },
                        { icon: 'pi pi-eye-slash' },
                        { icon: 'pi pi-facebook' },
                        { icon: 'pi pi-fast-backward' },
                        { icon: 'pi pi-fast-forward' },
                        { icon: 'pi pi-file' },
                        { icon: 'pi pi-file-excel' },
                        { icon: 'pi pi-file-o' },
                        { icon: 'pi pi-file-pdf' },
                        { icon: 'pi pi-filter' },
                        { icon: 'pi pi-folder' },
                        { icon: 'pi pi-folder-open' },
                        { icon: 'pi pi-forward' },
                        { icon: 'pi pi-github' },
                        { icon: 'pi pi-globe' },
                        { icon: 'pi pi-google' },
                        { icon: 'pi pi-heart' },
                        { icon: 'pi pi-home' },
                        { icon: 'pi pi-id-card' },
                        { icon: 'pi pi-image' },
                        { icon: 'pi pi-images' },
                        { icon: 'pi pi-inbox' },
                        { icon: 'pi pi-info' },
                        { icon: 'pi pi-info-circle' },
                        { icon: 'pi pi-key' },
                        { icon: 'pi pi-list' },
                        { icon: 'pi pi-lock' },
                        { icon: 'pi pi-lock-open' },
                        { icon: 'pi pi-map-marker' },
                        { icon: 'pi pi-microsoft' },
                        { icon: 'pi pi-minus' },
                        { icon: 'pi pi-minus-circle' },
                        { icon: 'pi pi-mobile' },
                        { icon: 'pi pi-money-bill' },
                        { icon: 'pi pi-palette' },
                        { icon: 'pi pi-paperclip' },
                        { icon: 'pi pi-pause' },
                        { icon: 'pi pi-pencil' },
                        { icon: 'pi pi-play' },
                        { icon: 'pi pi-plus' },
                        { icon: 'pi pi-plus-circle' },
                        { icon: 'pi pi-power-off' },
                        { icon: 'pi pi-print' },
                        { icon: 'pi pi-question' },
                        { icon: 'pi pi-question-circle' },
                        { icon: 'pi pi-refresh' },
                        { icon: 'pi pi-replay' },
                        { icon: 'pi pi-reply' },
                        { icon: 'pi pi-save' },
                        { icon: 'pi pi-search' },
                        { icon: 'pi pi-search-minus' },
                        { icon: 'pi pi-search-plus' },
                        { icon: 'pi pi-share-alt' },
                        { icon: 'pi pi-shopping-cart' },
                        { icon: 'pi pi-sign-in' },
                        { icon: 'pi pi-sign-out' },
                        { icon: 'pi pi-sitemap' },
                        { icon: 'pi pi-sliders-h' },
                        { icon: 'pi pi-sliders-v' },
                        { icon: 'pi pi-sort' },
                        { icon: 'pi pi-sort-alpha-down' },
                        { icon: 'pi pi-sort-alpha-down-alt' },
                        { icon: 'pi pi-sort-alpha-up' },
                        { icon: 'pi pi-sort-alpha-up-alt' },
                        { icon: 'pi pi-sort-alt' },
                        { icon: 'pi pi-sort-amount-down' },
                        { icon: 'pi pi-sort-amount-down-alt' },
                        { icon: 'pi pi-sort-amount-up' },
                        { icon: 'pi pi-sort-amount-up-alt' },
                        { icon: 'pi pi-sort-down' },
                        { icon: 'pi pi-sort-numeric-down' },
                        { icon: 'pi pi-sort-numeric-down-alt' },
                        { icon: 'pi pi-sort-numeric-up' },
                        { icon: 'pi pi-sort-numeric-up-alt' },
                        { icon: 'pi pi-sort-up' },
                        { icon: 'pi pi-spinner' },
                        { icon: 'pi pi-star' },
                        { icon: 'pi pi-star-o' },
                        { icon: 'pi pi-step-backward' },
                        { icon: 'pi pi-step-backward-alt' },
                        { icon: 'pi pi-step-forward' },
                        { icon: 'pi pi-step-forward-alt' },
                        { icon: 'pi pi-table' },
                        { icon: 'pi pi-tablet' },
                        { icon: 'pi pi-tag' },
                        { icon: 'pi pi-tags' },
                        { icon: 'pi pi-th-large' },
                        { icon: 'pi pi-thumbs-down' },
                        { icon: 'pi pi-thumbs-up' },
                        { icon: 'pi pi-ticket' },
                        { icon: 'pi pi-times' },
                        { icon: 'pi pi-times-circle' },
                        { icon: 'pi pi-trash' },
                        { icon: 'pi pi-twitter' },
                        { icon: 'pi pi-undo' },
                        { icon: 'pi pi-unlock' },
                        { icon: 'pi pi-upload' },
                        { icon: 'pi pi-user' },
                        { icon: 'pi pi-user-edit' },
                        { icon: 'pi pi-user-minus' },
                        { icon: 'pi pi-user-plus' },
                        { icon: 'pi pi-users' },
                        { icon: 'pi pi-video' },
                        { icon: 'pi pi-volume-down' },
                        { icon: 'pi pi-volume-off' },
                        { icon: 'pi pi-volume-up' },
                        { icon: 'pi pi-wifi' },
                        { icon: 'pi pi-window-maximize' },
                        ]
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get('/adm/crud-generator/api/data/'+this.$route.params.file).then((response) => {
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
                    icon: '',
                    type: 'text',
                    visible: 1,
                    visible_edit: 1,
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
                    translatable: 0,
                })


            },
            inputParams(input) {
                let params = []
                if (input.type == 'text') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min', 'translatable')
                }
                if (input.type == 'textarea') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'email') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'url') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'tel') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'number') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'money') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'password') {
                    params.push('validate', 'label', 'unique', 'default', 'nullable', 'validate', 'max', 'min')
                }
                if (input.type == 'true_or_false') {
                    params.push('label', 'default')
                }
                if (input.type == 'multimedia_file') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'gallery') {
                    params.push('listable', 'validate', 'label', 'nullable')
                }
                if (input.type == 'date') {
                    params.push('validate', 'label', 'nullable', 'validate')
                }
                if (input.type == 'time') {
                    params.push('validate', 'label', 'nullable', 'validate')
                }
                if (input.type == 'datetime') {
                    params.push('validate', 'label', 'nullable', 'validate')
                }
                if (input.type == 'week') {
                    params.push('validate', 'label', 'nullable', 'validate')
                }
                if (input.type == 'select') {
                    params.push('validate', 'label', 'default', 'nullable', 'validate', 'valueoriginselector')
                }
                if (input.type == 'radio') {
                    params.push('validate', 'label', 'default', 'nullable', 'validate', 'valueoriginselector')
                }
                if (input.type == 'checkbox') {
                    params.push('validate', 'label', 'default', 'nullable', 'validate', 'valueoriginselector')
                }
                if (input.type == 'select2') {
                    params.push('validate', 'label', 'default', 'nullable', 'validate', 'valueoriginselector')
                }
                if (input.type == 'select2multiple') {
                    params.push('validate', 'label', 'default', 'nullable', 'validate', 'valueoriginselector')
                }
                //params.push('visible')
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

                axios.post('/adm/crud-generator/', formData).then((response) => {
                    this.loaded = 3
                    setTimeout(() => {
                        this.loaded = 1

                        EventBus.$emit('reloadMenu');
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

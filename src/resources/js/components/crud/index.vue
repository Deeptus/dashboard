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
                    Crud
                </div>
                <div class="card-body pb-0">
                    <div class="row">
                        <InputLayout :relations="relations" :subForm="subForm" :value="content[input.columnname]" :input="input" v-for="(input, inputk) in inputs" :key="inputk"></InputLayout>
                    </div>
                </div>
            </div>
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
    import InputLayout from './InputLayout'
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
        components: {
            InputLayout
        },
        data(){
            return{
                languages: {},
                tablename: '',
                table: {},
                inputs: [],
                content: {},
                relations: {},
                subForm: {},
                loaded: 0
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(this.urlData).then((response) => {
                    this.languages = response.data.languages
                    this.tablename = response.data.tablename
                    this.table     = response.data.table
                    this.inputs    = response.data.inputs
                    this.relations = response.data.relations
                    this.subForm   = response.data.subForm
                    this.inputs.forEach(input => {
                        this.content[input.columnname] = {
                            value: input.default,
                            errors: []
                        }
                    });
                    if(response.data.content) {
                        this.inputs.forEach(input => {
                            if (input.type == 'gallery') {
                                this.content[input.columnname] = {
                                    value: response.data.galleries[input.columnname],
                                    errors: []
                                }
                            } else if (input.type == 'map-select-lat-lng') {
                                this.$set(this.content[input.columnname], 'value', {})
                                this.$set(this.content[input.columnname].value, 'lat', parseFloat(response.data.content[input.columnname + '_lat']))
                                this.$set(this.content[input.columnname].value, 'lng', parseFloat(response.data.content[input.columnname + '_lng']))
                            } else {
                                this.content[input.columnname].value = response.data.content[input.columnname]
                            }
                        });
                    }

                    this.loaded = 1
                });
            });
        },
        mounted () {},
        watch: {},
        methods: {
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
            attachInput(formData, input, content) {
                if (input.type == 'gallery') {
                    if (content.value.length) {
                        content.value.forEach((file, index) => {
                            if (file && file instanceof File) {
                                formData.append(input.columnname + '['+index+']', file)
                            }
                            if (typeof file === 'string' || file instanceof String) {
                                formData.append(input.columnname + '['+index+']', file)
                            }
                            if (typeof file === 'object' || file instanceof Object) {
                                formData.append(input.columnname + '['+index+']', file.id)
                            }
                        })
                    }
                }else if (input.type == 'multimedia_file') {
                    formData.append(input.columnname, content.value)
                }else if (input.type == 'map-select-lat-lng') {
                    formData.append(input.columnname + '_lat', content.value.lat);
                    formData.append(input.columnname + '_lng', content.value.lng);
                }else if (input.type == 'subForm') {
                    content.value.forEach((item, index) => {
                        let subFormData = new FormData()
                        this.subForm[input.columnname].inputs.forEach(subInput => {
                            this.attachInput(subFormData, subInput, item.content[subInput.columnname])
                        });
                        if (item.content['id']) {
                            formData.append(input.columnname + '[' + index + '][id]', item.content['id'].value)
                        }

                        [...subFormData.entries()].forEach(pair => {
                            formData.append(input.columnname + '[' + index + '][' + pair[0] + ']', pair[1])
                        });
                    });
                } else {
                    formData.append(input.columnname, content.value);
                }
            },
            postForm() {
                let formData = new FormData()
                var subForm = {}

                this.inputs.forEach(input => {
                    this.attachInput(formData, input, this.content[input.columnname])
                });
                formData.append('subForm', JSON.stringify(subForm));

                axios.post(this.urlAction, formData).then((response) => {
                    this.loaded = 3
                    setTimeout(() => {
                        // this.loaded = 1
                        window.location.href = this.urlBack
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

                    if (error.response.data.message == 'The given data was invalid.'){


                        let parsedErrors  = '';
                        let errorData = error.response.data.errors
                        Object.keys(error.response.data.errors).forEach(item =>  
                            
                            parsedErrors += '<div style="text-align: center;"> ' + errorData[item] + ' </div>'
                        );

                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            html: parsedErrors,
                            showCancelButton: false,
                            confirmButtonText: 'Aceptar',                            
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                
                            }
                        })


                    }

                    this.loaded = 1
                })
            }
        },
        computed: {
        }
    }
</script>
<style lang="scss" scoped>
</style>

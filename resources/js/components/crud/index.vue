<template>




    <div class="row">
<Toast position="top-right" />


        <div class="col-md-12">
            <div class="row justify-content-center" v-if="loaded == 0">
                <h3><center><i class="fas fa-sync fa-spin"></i><br>Cargando</center></h3>
            </div>
            <div class="row justify-content-center" v-if="loaded == 2">
                <h3><center><i class="fas fa-sync fa-spin"></i><br>Guardando</center></h3>
            </div>
            <div class="row justify-content-center" v-if="loaded == 3">
                <Message severity="success">Se guardo correctamente.</Message>
            </div>
        </div>

        <div class="p-col-12" v-if="loaded == 1">


            <div class="card">
                <div class="card-header">
                   <h5> {{ table.name['es'] }} </h5>
                </div>
                <div class="card-body pb-0">
                    <div class="p-fluid p-grid p-formgrid">
                        <InputLayout :relations="relations" :value="content[input.columnname]" :input="input" v-for="(input, inputk) in inputs" :key="inputk" ></InputLayout>
                    </div>
                </div>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mt-4">

                <Button type="button" @click="sendForm()" class="btn btn-lg btn-primary" icon="pi pi-save" label="Guardar" />
            </div>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    import InputLayout from './InputLayout'
    import Swal from 'sweetalert2'
    import Toast from 'primevue/toast';
    import CrudService from './../../../../../../../resources/js/service/CrudService';
    import Message from 'primevue/message';
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
            InputLayout,
            Message
        },
        data(){
            return{
                languages: {},
                messages: [],
                tablename: '',
                table: {},
                inputs: [],
                content: {},
                edit: null,
                loaded: 0
            }
        },
        created() {

        this.CrudService = new CrudService();

            this.tablename = this.$route.params.table

            this.edit = this.$route.params.id
            //this.CrudService.getTable(this.tablename).then(data => this.inputs = data.inputs);
            this.$nextTick(() => {
                let nurl = ''
                let url = this.tablename
                if(this.edit){
                    nurl = '../../crud/' + url + '/api/data/' + this.edit
                }else{
                    nurl = url
                }

                this.CrudService.getTable(nurl).then((response) => {
                    console.log(response)
                    this.languages = response.languages
                    this.tablename = response.tablename
                    this.table     = response.table
                    this.inputs    = response.inputs
                    this.relations = response.relations
                    this.inputs.forEach(input => {
                        this.content[input.columnname] = {
                            value: input.default,
                            errors: []
                        }
                    });
                    if(response.content) {
                        this.inputs.forEach(input => {
                            this.content[input.columnname].value = response.content[input.columnname]
                        });
                    }
                    this.loaded = 1
                });
            });

        },
        mounted () {},
        watch: {
        },
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
            postForm() {
                let formData = new FormData()

                this.inputs.forEach(input => {
                    console.log(this.content[input.columnname].value)
                    formData.append(input.columnname, this.content[input.columnname].value);
                });

                let edcheck = ''
                if(this.edit){
                    edcheck = '/'+this.edit
                }
                
                axios.post('/adm/crud/' + this.tablename + edcheck, formData).then((response) => {
                    this.loaded = 3
                    setTimeout(() => {
                        //this.loaded = 1
                        window.location.href = '/adm/home#/crud/' + this.tablename
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

                        Object.keys(error.response.data.errors).forEach(item =>  {
                            //console.log(errorData[item][0])
                            this.$toast.add({severity:'error', summary: 'Error', detail: errorData[item][0], life: 5000})

                            }
                            //parsedErrors = parsedErrors + '<div style="text-align: center;"> ' + errorData[item] + ' </div>'
                        ).bind(this);

                            



                    }

                    this.loaded = 1
                })
            }
        },
        computed: {
        }
    }
</script>
<style lang="css" scoped>
.form-label {
    margin-bottom: .5rem;
    font-weight: bold;
}
</style>

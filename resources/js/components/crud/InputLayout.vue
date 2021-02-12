<template>
    <div :class="'p-field p-col-12 p-md-' + input.gridcols">


        <InputText  :value="value" :input="input" v-if="layout[input.type] == 'basic'" ></InputText>


        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>


        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'" ></InputDate>


<input type="file" v-if="layout[input.type] == 'file'" name="file"  :input="input"   @change="upload($event)" /> 
        <!---<
        <FileUpload  v-if="layout[input.type] == 'file'"  name="files[]" url="/adm/inge/up" :multiple="true" />--->


    </div>

</template>
<script>
    import InputText from './InputText'
    import InputDate from './InputDate'
    import InputSelect from './InputSelect'

    export default {
        props: {
            input: {
                type: Object,
                default: {}
            },
            relations: {
                default: {}
            },
            value: {
                type: Object,
                default: {}
            },
            /*propObject: {
                type: Object,
                default: () => ({
                    nombre: null,
                    apellido: null,
                    tipo: null,
                    tipoContribuyente: null,
                    domicilioFiscal: null,
                })
            },*/


        },
        components: {
            InputText,
            InputSelect,
            InputDate
        },
        data(){
            return{
                propObject: {
                    0: null,
                    1: null,
                    2: null,
                    3: null,
                    4: null,

                },
                layout: {
                    "text": 'basic',
                    "textarea": 'basic',
                    "email": 'basic',
                    "url": 'basic',
                    "tel": 'basic',
                    "number": 'basic',
                    "money": 'basic',
                    "password": 'basic',
                    "true_or_false": 'select',
                    "date": 'date',
                    "time": 'date',
                    "datetime": 'date',
                    "week": 'date',
                    "select": 'select',
                    "radio": 'select',
                    "checkbox": 'select',
                    "select2": 'select',
                    "select2multiple": 'select',
                    "file": 'file',
                }
            }
        },
        created() {
        },
        mounted () {


            this.$root.$on('setAfip', data => {

                ///console.log(data)
                let helper = data.split(',') 
                this.propObject = Object.assign({}, helper);//{ ...[helper] }
                
               // console.log(data);
                /*this.propObject.nombre                 = data.nombre
                this.propObject.apellido               = data.apellido
                this.propObject.tipoContribuyente      = data.tipoContribuyente
                this.propObject.domicilioFiscal        = data.domicilioFiscal*/

            });


        },
        watch: {


        },
        methods: {

 upload(event){
    let data = new FormData();
    let file = event.target.files[0];

    data.append('name', 'my-file')
    data.append('file', file)



  },
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>


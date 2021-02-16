<template>
    <div :class="'p-field p-col-12 p-md-' + input.gridcols">

        <InputTextDash  :value="value" :input="input" v-if="layout[input.type] == 'basic'" ></InputTextDash>


        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>


        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'" ></InputDate>


<Editor v-model="value.value" :value="value" :input="input" v-if="layout[input.type] == 'textarea'" editorStyle="height: 320px"/> 



<FileUpload  v-if="layout[input.type] == 'file'" mode="basic" name="demo[]" 
accept="image/*" :maxFileSize="1000000"  :customUpload="true" @uploader="myUploader" :auto="true"/>


    </div>

</template>
<script>
    import InputTextDash from './InputText'
    import InputDate from './InputDate'
    import InputSelect from './InputSelect'


    export default {
        props: {
            lang: {type: String,
                default: 'es'
            },
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
            InputTextDash,
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
                    "textarea": 'textarea',
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



        },
        watch: {


        },
        methods: {
        myUploader(event) {
            //event.files == files to upload

            this.$emit('input', event.files);
        }

        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>


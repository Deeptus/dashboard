<template>
    <div :class="'p-field  p-col-12 p-md-' + input.gridcols">

        <InputTextDash  :value="value" :input="input" v-if="layout[input.type] == 'basic'" ></InputTextDash>

        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>


        <InputRadio :relations="relations" :value="value" :input="input" 
        v-if="layout[input.type] == 'radio'"></InputRadio>

        <InputCheckbox :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'checkbox'"></InputCheckbox>

        <InputBoolean v-model="value"  v-if="layout[input.type] == 'boolean'"
        :relations="relations" :value="value" :input="input" />

        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'" ></InputDate>

        <Editor v-model="value.value" :value="value" :input="input" v-if="layout[input.type] == 'textarea'" editorStyle="height: 320px"/> 

        <FileUpload v-if="layout[input.type] == 'file'" mode="basic" name="demo[]" 
                    accept="image/*" :maxFileSize="1000000"  :customUpload="true" @uploader="myUploader" :auto="true"
        />

    </div>
</template>
<script>
    import InputTextDash from './InputText'
    import InputDate from './InputDate'
    import InputSelect from './InputSelect'
    import InputRadio from './InputRadio'
    import InputBoolean from './InputBoolean'
    import InputCheckbox from './InputCheckbox'

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
        },
        components: {
            InputTextDash,
            InputSelect,
            InputRadio,
            InputDate,
            InputBoolean,
            InputCheckbox
        },
        data(){
            return{

                layout: {
                    "text": 'basic',
                    "textarea": 'textarea',
                    "email": 'basic',
                    "url": 'basic',
                    "tel": 'basic',
                    "number": 'basic',
                    "money": 'basic',
                    "password": 'basic',
                    "boolean": 'boolean',
                    "date": 'date',
                    "time": 'date',
                    "datetime": 'date',
                    "week": 'date',
                    "select": 'select',
                    "radio": 'radio',
                    "checkbox": 'checkbox',
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


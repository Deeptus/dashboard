<template>
    <div :class="'col-md-' + input.gridcols">
        <InputText :value="value" :input="input" v-if="layout[input.type] == 'basic'" @child-cuit="setDireccion"></InputText>
        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>
        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'" ></InputDate>

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
            }
        },
        components: {
            InputText,
            InputSelect,
            InputDate
        },
        data(){
            return{
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
                }
            }
        },
        created() {
        },
        mounted () {},
        watch: {


        },
        methods: {
                setDireccion: function (x) {
                    console.log(x)
                }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>


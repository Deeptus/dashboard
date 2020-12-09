<template>
    <div :class="'col-md-' + input.gridcols">
        <InputText :value="value" :input="input" v-if="layout[input.type] == 'basic'"></InputText>
        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>
        <SubForm :relations="{}" :value="value" :subForm="subForm" :input="input" v-if="layout[input.type] == 'subForm'"></SubForm>
    </div>
</template>
<script>
    import InputText from './InputText'
    import InputSelect from './InputSelect'
    import SubForm from './SubForm'

    export default {
        name:"InputLayout",
        props: {
            input: {
                type: Object,
                default: {}
            },
            relations: {
                default: {}
            },
            subForm: {
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
            SubForm
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
                    "subForm": 'subForm'
                }
            }
        },
        created() {
        },
        mounted () {},
        watch: {},
        methods: {
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>

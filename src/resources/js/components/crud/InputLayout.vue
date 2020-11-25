<template>
    <div :class="'col-md-' + input.gridcols">
        <InputText :value="value" :input="input" v-if="layout[input.type] == 'basic'"></InputText>
        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>
    </div>
</template>
<script>
    import InputText from './InputText'
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
            InputSelect
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
        watch: {},
        methods: {
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>

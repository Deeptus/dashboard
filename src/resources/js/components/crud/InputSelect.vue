<template>
    <div class="form-floating mb-3">
        <select class="form-select" v-model="value.value">
            <option :value="key" v-for="(option, key) in options" :key="key">{{ option }}</option>
        </select>
        <label>{{ input.label[lang()] }}</label>
    </div>
</template>
<script>

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
        components: {},
        data(){
            return{
                options: {}
            }
        },
        created() {
            this.options = {
                0: 'No',
                1: 'Yes'
            }
            if (this.input.type == 'select') {
                this.options = this.relations[this.input.tabledata]
            }
        },
        mounted () {},
        watch: {},
        methods: {
            lang() {
                return document.documentElement.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>

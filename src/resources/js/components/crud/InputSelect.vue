<template>
    <div class="form-floating mb-3">
        <select class="form-select" v-model="value.value">
            <option :value="null">
                N/A
            </option>
            <template v-if="mode == 'table'">
                <option :value="key" v-for="(option, key) in options" :key="key">{{ option }}</option>
            </template>
            <template v-if="mode == 'model-nocrud'">
                <option :value="key" v-for="(option, key) in options" :key="key">{{ option }}</option>
            </template>
            <template v-if="mode == 'values'">
                <option :value="option.key" v-for="(option, key) in options" :key="key">{{ option.text }}</option>
            </template>
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
                options: {},
                mode: this.input.valueoriginselector
            }
        },
        created() {
            this.options = {
                0: 'No',
                1: 'Yes'
            }

            if (this.mode == 'table') {
                this.options = this.relations[this.input.tabledata]
            }
            if(this.mode == 'values'){
                this.options = this.input.options
            }
            if(this.mode == 'model-nocrud'){
                this.options = this.relations[this.input.tabledata]
            }
            
        },
        mounted () {
            
        },
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

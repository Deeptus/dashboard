<template>
    <fieldset class="mb-3">
        <legend>{{ input.label[lang()] }}:</legend>
        <div class="row">
            <div class="col-md-4 col-lg-3" v-for="(option, key) in options" :key="key">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input
                        type="checkbox"
                        v-bind:value="key"
                        v-model="value.value"
                        :id="input.columnname + '-' + key"
                        >
                    </div>
                    <label :for="input.columnname + '-' + key" class="form-control">{{ option }}</label>
                </div>
            </div>
            <!--
            <div class="form-floating mb-3">
                <select class="form-select" v-model="value.value">
                    <template v-if="mode == 'table'">
                        <option :value="key" v-for="(option, key) in options" :key="key">{{ option }}</option>
                    </template>
                    <template v-if="mode == 'values'">
                        <option :value="option.key" v-for="(option, key) in options" :key="key">{{ option.text }}</option>
                    </template>
                </select>
                <label>{{ input.label[lang()] }}</label>
            </div>
            <button @click="test()">test</button>
            -->
        </div>
    </fieldset>
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
            }else if(this.mode == 'values'){
                this.options = this.input.options
            }
            
        },
        mounted () {
            
        },
        watch: {},
        methods: {
            test() {
                console.log(this.value)
            },
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

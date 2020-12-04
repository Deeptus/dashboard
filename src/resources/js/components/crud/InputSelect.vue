<template>
    <div class="form-floating mb-3">
        <label class="form-label">{{ input.label[lang()] }}</label>
        <select class="form-select" v-model="value.value">
            <option value="0"  v-if="!mode">Si</option>
            <option value="1" v-if="!mode" selected="">No</option>
            <option :value="key" v-for="(option, key) in options" :key="key" v-if="mode == 'table'">{{ option }}</option>
            <option :value="option.key" v-for="(option, key) in options" :key="key" v-if="mode == 'values'">{{ option.text }}</option>
        </select>
        
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

            if (this.mode == 'table') {
                this.options = this.relations[this.input.tabledata]
            }else if(this.mode == 'values'){
                this.options = this.input.options
            }

            this.value.value = this.input.default
            //console.log(this.value.value)

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
<style lang="css" scoped>
.form-label {
    margin-bottom: .5rem;
    font-weight: bold;
}
</style>

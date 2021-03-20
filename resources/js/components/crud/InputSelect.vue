<template>
    <div class="form-floating mb-3">

        <label class="form-label">{{ input.label[lang()] }}</label>

        <Dropdown 
            v-model="selected"
            @change="setSelect($event.value)"
            :value="value.value"
            optionLabel="text" 
            optionValue="key"
            :options="options" 
            :placeholder="'Seleccione ' + input.label[lang()]">
        </Dropdown>

       <!--- <select class="p-fieldex" v-model="value.value">
            <option value="0"  v-if="!mode">Si</option>
            <option value="1" v-if="!mode" selected="">No</option>
            <option :value="key" v-for="(option, key) in options" :key="key" :v-if="mode == 'table'">{{ option }} {{ mode }}</option>
            <option :value="option.key" v-for="(option, key) in optionsA" :key="key" :v-else-if="mode == 'values'">{{ option.text }}</option> 
        </select> --->
        
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
                selected: 0,
                options: [],
                optionsA: [],                
                mode: this.input.valueoriginselector
            }
        },
        created() {


            //this.value.value = this.input.default
            //console.log(this.value.value)

        },
        mounted () {

            this.selected = String(this.value.value)

            if (this.mode == 'table') {
                    const obj = this.relations[this.input.tabledata]
               
                    var result = Object.keys(obj).map(function (key) { 
                        return {'key': Number(key), 'text': obj[key]}; 
                    }); 
        
                    this.options = result  

            }else if(this.mode == 'values'){
                this.options = this.input.options
            }

        },
        watch: {},
        methods: {
            setSelect(event){
                    console.log(event)
                    
                    this.value.value = event
            },
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

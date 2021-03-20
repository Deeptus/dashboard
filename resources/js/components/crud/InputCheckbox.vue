<template>
    <div class="form-floating mb-3">

        <label class="form-label">{{ input.label[lang()] }}</label>

<div v-for="category of options" :key="category.key" class="p-field-radiobutton">
    <Checkbox  :id="category.key" name="category" :value="category.key" v-model="selected"  />
    <label :for="category.key">{{category.text}}</label>
</div>
        
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
                selected: null,
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
            
            //console.log(this.value.value)
            if(this.value.value){
                this.selected = this.value.value.split(',')
            }

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
        watch: {
            selected(oldVal, newVal){

                this.value.value = this.selected

            }

        },
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

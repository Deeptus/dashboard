<template>
    <div class="form-floating mb-3">

        <label class="form-label">{{ input.label[lang()] }}</label>

<div v-for="category of options" :key="category.key" class="p-field-radiobutton">
    <RadioButton :id="category.key" name="category" :value="Number(category.key)" v-model="selected" 

                 />
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
                selected: {},
                options: [],
                optionsA: [],                
                mode: this.input.valueoriginselector
            }
        },
        created() {

           this.selected = this.value.value


        },
        mounted () {

            //this.selected = this.value.value

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
            
            selected(val){
              // console.log(val)
              this.value.value = val
            }

        },
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

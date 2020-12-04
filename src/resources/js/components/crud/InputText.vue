<template>
    <div class="form-floating mb-3">
        <label class="form-label">{{ input.label[lang()] }} </label>   
        <input v-if="this.columna == 'cuit'" type="text" class="form-control" v-model="cuit" :disabled="disabled == true">
        <input v-else type="text" class="form-control" v-model="value.value" :placeholder="input.label[lang()]">


    </div>
</template>
<script>

    export default {
        props: {
            input: {
                type: Object,
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
                columna: null,
                cuit: null,
                disabled: false,
                domicilioFiscal: {},
            }
        },
        created() {

            if(this.input.columnname == 'CUIT'){
                this.columna = 'cuit'
            }
        },
        mounted () {},
      watch: {
        domicilioFiscal(value){
            console.log(value)
            this.$emit("child-cuit", value);
        },
        cuit(value){
        


            if(value.length == 11){
                this.disabled = true
                this.setAddress()

            }

        }
      },
        methods: {
            async setAddress(){


                axios.get('https://cors-anywhere.herokuapp.com/http://ec2-18-221-162-177.us-east-2.compute.amazonaws.com/afip-api/public/?cuit='+this.cuit)
                .then(res => {
                    this.disabled = false
                    this.domicilioFiscal = res.data.domicilioFiscal                
                }).catch(err => {
                    console.log(err.response);
                });


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

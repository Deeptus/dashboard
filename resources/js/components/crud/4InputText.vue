<template>
    <div class="form-floating mb-3">
        <label class="form-label">{{ input.label[lang()] }} </label>   

        <!--- <div v-if="input.label[lang()] == 'Localidad'"> ***
            <span v-if="afipdata.domicilioFiscal !== null && this.input.columnname == 'locality' "> {{ afipdata.domicilioFiscal.localidad }}</span>
        </div>- v-else          {{ this.columna }}
        {{ this.columna }}  {{ value }} 
       
        <input v-if="this.columna == 'CUIT'" type="text" class="form-control"  v-model="value.value" :disabled="disabled == true">         
        <input v-else-if="this.columna == 'address'" type="text" class="form-control" v-model="value.value" :disabled="disabled == true">       
        <input v-else-if="this.columna == 'name'" type="text" class="form-control" v-model="value.value" :disabled="disabled == true">       
        <input v-else-if="this.columna == 'locality'" type="text" class="form-control" v-model="value.value" :disabled="disabled == true">       
        <input v-else-if="this.columna == 'province'" type="text" class="form-control" v-model="value.value" :disabled="disabled == true">       
        <input v-else-if="this.columna == 'cp'" type="text" class="form-control" v-model="value.value" :disabled="disabled == true">      --> 
        {{ input }}
        <input type="text" class="form-control" v-model="value.value" :placeholder="input.label[lang()]" :ref="this.columna" :disabled="input.visible_edit == 0">

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
            },
            afipdata: {
                type: Object,
                default: {

                }
            }
        },
        components: {},
        data(){
            return{
                columna: '', 
                cuit: null,
                localityAfip: null,
                disabled: false,
                domicilioFiscal: {},
                tipoContribuyente: null,
                domicilioFiscal: null,
                nombre: null,
                cpAfip: null,
                provAfip: null,
                srAfip: null,
                direAfip: null,
            }
        },
        created() {
//            if(this.input.columnname == 'locality'){
                //console.log( this.input.columnname)
                this.columna = this.input.columnname
            /*}
            if(this.input.columnname == 'CUIT'){
                this.columna = 'cuit'
            }*/
        },
        mounted () {


        },
      watch: {

  afipdata: {
    // the callback will be called immediately after the start of the observation
    immediate: false, 
     deep: true,
    handler (val, oldVal) {

        console.log('afip data on input text',val)

        /*if(this.columna == 'province'){

            console.log(this.afipdata[2])
            this.value = this.afipdata[2]
        }*/

      // do your stuff
  /*    if(this.columna == 'province'){        
       // console.log(this.afipdata.domicilioFiscal.descripcionProvincia )

       console.log('aca ctm', this.afipdata)
       //this.value.value = 'je'

        Object.assign(this.afipdata, val)
        this.value.value = 'je'

        //this.$root.$emit('eventing', val);
      }
*/
/*
     if(val.domicilioFiscal !== null){
      //console.log(val)
        if(val.domicilioFiscal.direccion){
            //this.$root.$emit('eventing', res.data);
            this.value.value = val.domicilioFiscal.direccion
        }

*/
      /*this.direAfip         = val.domicilioFiscal.direccion
      this.srAfip           = val.apellido + ' ' + val.nombre
      this.localityAfip     = val.domicilioFiscal.localidad
      this.cpAfip           = val.domicilioFiscal.codPostal
      this.provAfip         = val.domicilioFiscal.descripcionProvincia*/


    }


  },
     columna: function(newVal, oldVal){
         //to work with changes in prop
         console.log(newVal)
     },
        cuit(value){

            //console.log(value)
        


            if(value.length == 11){
                this.disabled = true
                //this.value.value = value
                this.setAddress()

            }

        }
      },
        methods: {
            async setAddress(){


                axios.get('https://cors-anywhere.herokuapp.com/http://ec2-18-221-162-177.us-east-2.compute.amazonaws.com/afip-api/public/?cuit='+this.cuit)
                .then(res => {
                    this.disabled                       = false/*
                    this.tipoContribuyente              = res.data.tipoContribuyente
                    this.domicilioFiscal                = res.data.domicilioFiscal    
                    this.nombre                         = res.data.nombre + this.data.apellido

*/                 // console.log(res.data.apellido)
                    //this.afipdata.value1 = res.data.apellido
                    if(res.data.status == 'success'){        
                    /*console.log( res.data.domicilioFiscal.direccion +  ',' + res.data.domicilioFiscal.localidad +  ',' + res.data.domicilioFiscal.descripcionProvincia + ',' + 'ARGENTINA,' + res.data.domicilioFiscal.codPostal)*/
                    let afip = res.data.domicilioFiscal.direccion +  ',' + res.data.domicilioFiscal.localidad +  ',' + res.data.domicilioFiscal.descripcionProvincia + ',' + 'ARGENTINA,' + res.data.domicilioFiscal.codPostal
                    
                    //this.afipdata.domicilioFiscal.descripcionProvincia = res.data.domicilioFiscal.descripcionProvincia
                    this.$root.$emit('setAfip', afip) //.domicilioFiscal.descripcionProvincia);

                    }

                }).then(res => { 




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


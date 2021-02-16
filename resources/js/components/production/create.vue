<template>
    <div class="card">


        <form class="p-fluid p-grid p-formgrid"  v-on:submit.prevent="submitForm">
    <div class="p-field p-col-12 p-md-4">
<h5>Cliente</h5>
<AutoComplete v-model="selectedClient" :suggestions="filteredClients" 
@complete="searchClients($event)" field="name" :dropdown="true"
@item-select="form.client_id = selectedClient.id"
/>
</div>

    <div class="p-field p-col-12 p-md-4">

    <h5>Orden de Compra</h5>
    <InputText type="text" v-model="form.oc" />

</div>


    <div class="p-field p-col-12 p-md-1">
<h5>Cotizado</h5>
<InputSwitch v-model="form.cotizado" />

</div>

    <div class="p-field p-col-12 p-md-2">
<h5>Moneda</h5>
<Dropdown v-model="form.moneda" :options="monedas" optionValue="code" optionLabel="name" placeholder="Seleccione moneda" />


</div>

    <div class="p-field p-col-12 p-md-3">
<h5>Neto</h5>
        <InputNumber id="currency-us" v-model="form.neto_iva" mode="decimal"  :minFractionDigits="2"  />
    </div>
    <div class="p-field p-col-12 p-md-1">

<!----     <h5>Cantidad</h5>
    <InputNumber v-model="form.cantidad" />
--->
</div>

    <div class="p-field p-col-12 p-md-4">
        <h5>Ingreso</h5>
        <Calendar dateFormat="dd.mm.yy"  id="basic" v-model="form.ingreso" />
    </div>

    <div class="p-field p-col-12 p-md-4">
        <h5>Prometida</h5>
        <Calendar dateFormat="dd.mm.yy"  id="basic" v-model="form.promesa" />
    </div>

    <div class="p-field p-col-12 p-md-4">

    <h5>Preguntas</h5>
    <InputText type="text" v-model="form.preguntas" />

</div>

<!----    <div class="p-field p-col-12 p-md-4">
<h5>Sector</h5>
<Dropdown v-model="form.sector" :options="sectores" optionValue="id" optionLabel="name" placeholder="Seleccione sector" />


</div> ------->

    <div class="p-field p-col-12 p-md-12">
      <h5>Detalle</h5>
<textarea v-model="form.detail" :autoResize="true" rows="5" cols="30" /></textarea>
</div>


  <div class="p-field p-col-12 p-md-12"">

    <Button  v-on:click="submitForm()"  class="" label="Generar" />
  </div>
</form>


    </div>
</template>

<script>
import ClientService from '../../service/ClientService';
import SectorService from '../../service/SectorService';

import moment from 'moment'

    export default {
        components: {
        },
        props: ['options', 'csrf'],
        data(){
            return{
              clients: null,
              sectores: null,
              filteredClients: null,
              selectedClient: null,
              form: {
                    cotizado: false,
                    preguntas: 'Nicolas',
                    detail: '',
                    newClient: 0,
                    estado: 2,
                    moneda: 1,
                    neto: null,
                    selectedOc: null,
                    oc: null,
                    ingreso: null,//new Date().toLocaleString(),
                    promesa: null, //new Date().toLocaleString(),
                    sector: null, //'Elija un sector',
                    client_id: 0,
                    ocs: []
                },
              monedas: [
                  {name: 'Pesos', code: '1'},
                  {name: 'Dolares', code: '2'},
                  {name: 'Euros', code: '3'},

              ],
            }
        },
        computed: {

        },
        created(){
           this.ClientService = new ClientService();
           this.SectorService = new SectorService();
        },
        watch: {


        },
        methods: {
          searchClients(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredClients = [...this.clients];
                }
                else {
                    this.filteredClients = this.clients.filter((client) => {
                        return client.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
          submitForm: function (message, event) {

            axios.post('/adm/produccion/crear', this.form)
                 .then((res) => {
                     //Perform Success Action
                     let s = res.data.status
                     let pid = res.data.pid
                     if(s == 'success'){
                      this.$router.push({name: 'pdetail', params: { id: pid } })
                     }
                 })
                 .catch((error) => {
                     // error.response.status Check status code
                 }).finally(() => {
                     //Perform action in always
                 });

          },

          },
        mounted() {
          this.ClientService.getClients().then(data => this.clients = data);
          this.SectorService.getSectores().then(data => this.sectores = data);
        }
    }
</script>

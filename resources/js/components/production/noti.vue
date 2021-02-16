<template>
    <div class="card">

<h2>Asignar orden de trabajo n° # </h2>

        <form class="p-fluid p-grid p-formgrid"  v-on:submit.prevent="submitForm">


    <div class="p-field p-col-12 p-md-4">
<h5 v-if="form.checked">Pieza precargada</h5>
<h5 v-else>Pieza nueva</h5>






<AutoComplete v-model="selectedPiece" :suggestions="filteredPieces" 
@complete="searchPieces($event)" field="name" :dropdown="true"
@item-select="form.piece_id = selectedPiece.id"
v-if="form.checked"

/>
    <InputText  v-model="form.newpiece" v-if="!form.checked" />

<div class="p-mt-2">
<InputSwitch v-model="form.checked" /> 


</div>

</div>




    <div class="p-field p-col-12 p-md-1">

    <h5>Cantidad</h5>
    <InputNumber v-model="form.quantity" />

</div>

    <div class="p-field p-col-12 p-md-3">
<h5>Material</h5>
<AutoComplete v-model="selectedMaterial" :suggestions="filteredMaterials" 
@complete="searchMaterials($event)" field="name" :dropdown="true"
@item-select="form.material_id = selectedMaterial.id"
/>
</div>
    <div class="p-field p-col-12 p-md-3">
<h5>Tratamiento térmico</h5>
<AutoComplete v-model="selectedTT" :suggestions="filteredTT" 
field="name" :dropdown="true"
@item-select="form.tratamiento_id = selectedTT.id"
/>
</div>


<div class="p-field p-col-12 p-md-6">

    <h5>Agregar planos:</h5>
<AutoComplete v-model="selectedPlane" :suggestions="filteredPlanes"  multiple
@complete="searchPlanes($event)" field="name" :dropdown="true"

/>

</div>


    <div class="p-field p-col-12 p-md-6">

    <h5>Consultar con:</h5>
    <InputText type="text" v-model="form.preguntas" />

</div>
<!---
    <div class="p-field p-col-12 p-md-4">
<h5>Sector</h5>
<Dropdown v-model="form.sector" :options="sectores" optionValue="id" optionLabel="name" placeholder="Seleccione sector" />


</div>
    <div class="p-field p-col-12 p-md-4">
<h5>Asignar</h5>
<Dropdown v-model="form.user_id" :options="users" optionValue="id" optionLabel="name" placeholder="Seleccione operador" />


</div> ---->
    <div class="p-field p-col-12 p-md-12">
      <h5>Detalle</h5>
<textarea  v-model="form.detail" rows="5" cols="100" /></textarea>
</div>


  <div class="p-field p-col-12 p-md-12"">

    <Button  v-on:click="submitForm()"  class="" label="Generar" />
  </div>
</form>


    </div>
</template>

<script>
import PieceService from '../../service/PieceService';
import SectorService from '../../service/SectorService';
import UserService from '../../service/UserService';
import MaterialService from '../../service/MaterialService';
import PlanesService from '../../service/PlanesService';

     import moment from 'moment'

    export default {

        props: ['options', 'csrf'],
        data(){
            return{
              production_id: this.$route.params.id,
              pieces: null,
              sectores: null,
              planes: null,
              users: null,
              materiales: null,
              filteredMaterials: null,
              filteredPieces: null,
              filteredPlanes: null,
              filteredTT: null,
              selectedPiece: null,
              selectedMaterial: null,
              selectedTT: null,
              selectedPlane: null,
              form: {
                    checked: false,
                    newpiece: null,
                    quantity: 1,
                    detail: "Realizar segun planos",
                    estado: 2,
                    moneda: 1,
                    neto: null,
                    tratamiento_id: null,
                    selectedOc: null,
                    oc: null,
                    ingreso: null,//new Date().toLocaleString(),
                    promesa: null, //new Date().toLocaleString(),
                    sector: null, //'Elija un sector',
                    material_id: null,
                    user_id: 0,
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
           this.PieceService = new PieceService();
           this.SectorService = new SectorService();
           this.UserService = new UserService();
           this.MaterialService = new MaterialService();
        },
        watch: {


        },
        methods: {
          searchPieces(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredPieces = [...this.clients];
                }
                else {
                    this.filteredPieces = this.pieces.filter((piece) => {
                        return piece.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
          searchPlanes(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredPlanes = [...this.planes];
                }
                else {
                    this.filteredPlanes = this.planes.filter((piece) => {
                        return piece.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
          searchMaterials(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredMaterials = [...this.materiales];
                }
                else {
                    this.filteredMaterials = this.materiales.filter((material) => {
                        return material.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
          submitForm: function (message, event) {

            axios.post('/adm/crearoti/' + this.production_id, this.form)
                 .then((res) => {
                     //Perform Success Action
                     let s = res.data.status
                     let oid = res.data.oid
                     if(s == 'success'){
                      this.$router.push({name: 'pdetail', params: { id: this.production_id } })
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
          this.PieceService.getPieces().then(data => this.clients = data);
          this.SectorService.getSectores().then(data => this.sectores = data);
          this.UserService.getUsers().then(data => this.users = data);
          this.MaterialService.getMaterials().then(data => this.materiales = data);
          this.PlanesService.getMaterials().then(data => this.planes = data);
        }
    }
</script>
